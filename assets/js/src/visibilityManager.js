/**
 * The visibilty manager is responsible for managing the visibility
 * of all the components within a form, based on their visibility 
 * conditions (if applicable).
 * 
 * How the algorithm works:
 * 
 * 1. A dependency graph is created. Each component with a visibility condition
 * or a component that is in one of the visibility conditions becomes a node.
 * The edges point from a node that controls the visibility of another node, to the node
 * whose visibility is being controlled by that node.
 * 
 * 2. A visibility traversal [1] is performed, strating from every node whose indegree is 
 * exactly 0. An indegree of 0 means that the component's visibility is not affected by the 
 * value of any other component in the graph, making it the starting node of a connected graph.
 * 
 * 3. An onChange event listener is added to every component whose node has an outdegree of more
 * than 0. An outdegree of more than 0 means that the component's value affects the visibility 
 * of one or more components in the graph. When the value of one of the components is 
 * changed, a visibility traversal is performed starting from the node whose value has changed.
 * 
 * [1] visibility traversal is a breadth first traversal, in which the visibility of each
 * node in the graph is evaluated, starting from the given node. The visibility of the adjacent
 * nodes is evaluated based on the value of the node at hand. If the evaluation process concludes 
 * that an adjacent node should be visible, it sets its visibility to true and recursively 
 * performs a visibility traversal from that node. Otherwise, if it should be hidden, it sets
 * its visibility to false and recursively sets the visibility of all of its dependency to
 * false as well.
 */
function VisibilityManager(form) {
    this.form = form;
    this.graph = new VisibilityGraph();
    this.init();
}

VisibilityManager.prototype.init = function() {
    // Step 1
    this.populateGraph();

    // Step 2
    this.setInitialVisibility();

    // Step 3
    this.addOnChangeListeners();
};

/**
 * Step 1 - graph population
 */
VisibilityManager.prototype.populateGraph = function() {
    var _this = this;

    this.form.$components.each(function(){
        var props = $(this).data('amarkal-ui-component').props;
        if(typeof props.show === 'string') {
            _this.graph.addNode(props.name);
            var regex = /\{\{(\S+)\}\}/g,
                name = regex.exec(props.show);
            while(null !== name) {
                _this.graph.addNode(name[1]);
                _this.graph.addEdge(name[1], props.name);
                name = regex.exec(props.show);
            }
        }
    });
};

VisibilityManager.prototype.setInitialVisibility = function() {
    var _this = this;

    this.graph.getNodes().forEach(function(node){
        if(_this.graph.indegree(node) === 0) {
            _this.visibilityTraversal(node);
        }
    });
};


VisibilityManager.prototype.addOnChangeListeners = function() {
    var _this = this;
    this.graph.getNodes().forEach(function(node){
        if(_this.graph.outdegree(node) > 0) {
            _this.form.getComponent(node).on('amarkal.change', function(e){
                _this.visibilityTraversal(node);
            });
        }
    });
};

/**
 * Evaluate the visibility of the components starting from the component
 * whose name is given.
 * 
 * @param {string} name 
 */
VisibilityManager.prototype.visibilityTraversal = function(name) {
    var queue = this.graph.adjacent(name),
        node  = queue.shift(),
        condition;
        
    while(typeof node !== 'undefined') {
        if(this.evaluateCondition(this.form.getComponent(node).amarkalUIComponent('getProps').show)) {
            this.form.getComponent(node).amarkalUIComponent('show');
            queue = queue.concat(this.graph.adjacent(node));
        }
        else {
            this.hideNode(node);
        }
        node = queue.shift();
    }
};

/**
 * Check if the given visibility condition is satisfied
 * by the current values of the compnents on which it is dependent.
 * @param {string} name 
 */
VisibilityManager.prototype.evaluateCondition = function(condition) {
    return eval(this.parseTemplate(condition));
};

/**
 * Hides the given node, and all of its dependencies
 * @param {string} name 
 */
VisibilityManager.prototype.hideNode = function(name) {
    var _this = this;
    this.form.getComponent(name).amarkalUIComponent('hide');
    this.graph.adjacent(name).forEach(function(node){
        _this.hideNode(node);
    });
};

/**
 * Convert placeholders in the given templates to their corresponding values
 * @param {string} template 
 */
VisibilityManager.prototype.parseTemplate = function(template) {
    var _this = this;
    return template.replace(/\{\{(\S+)\}\}/g, function(match, name){
        return JSON.stringify(_this.form.getValue(name));
    });
};

function VisibilityGraph() {
    this.nodes = [];
    this.edges = [];
}

/**
 * Adds a node to the graph.
 * @param {string} node 
 */
VisibilityGraph.prototype.addNode = function(node) {
    if(-1 === this.nodes.indexOf(node)){
        this.nodes.push(node);
    }
};

/**
 * Adds an edge from node "from" to node "to".
 * @param {string} from 
 * @param {string} to 
 */
VisibilityGraph.prototype.addEdge = function(from, to) {
    var _this = this,
        newEdge = {
        from: from,
        to: to
    };
    if(0 === this.edges.length) {
        this.edges.push(newEdge);
    }
    else {
        if(!this.edgeExists(from, to)) {
            this.edges.push(newEdge);
        }
    }
};

VisibilityGraph.prototype.edgeExists = function(from, to) {
    return this.edges.some(function(edge){
        if(edge.from === from && edge.to === to) {
            return true;
        }
        return false;
    });
};

/**
 * Computes the number of outgoing edges for the specified node.
 * @param {string} node 
 */
VisibilityGraph.prototype.outdegree = function(node) {
    var degree = 0;
    this.edges.forEach(function(edge){
        if(edge.from === node) {
            degree+=1;
        }
    });
    return degree;
};

/**
 * Computes the number of ingoing edges for the specified node.
 * @param {string} node 
 */
VisibilityGraph.prototype.indegree = function(node) {
    var degree = 0;
    this.edges.forEach(function(edge){
        if(edge.to === node) {
            degree+=1;
        }
    });
    return degree;
};

/**
 * Gets the adjacent node list for the specified node.
 * The "adjacent node list" is the set of nodes for which there is an incoming edge from the given node.
 * 
 * @param {string} node 
 */
VisibilityGraph.prototype.adjacent = function(node) {
    var adjacentNodes = [];
    this.edges.forEach(function(edge){
        if(edge.from === node) {
            adjacentNodes.push(edge.to);
        }
    });
    return adjacentNodes;
};

/**
 * List all nodes in the graph. Returns an array of node identifier strings.
 */
VisibilityGraph.prototype.getNodes = function() {
    return this.nodes;
};
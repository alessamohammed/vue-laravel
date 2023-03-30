<template>
	<div>
		<div
			v-show="showMenu"
			class="popover"
			:style="{
				left: `${x}px`,
				top: `${y}px`
			}"
			@mousedown.prevent=""
		>
			<span
				class="item"
				@mousedown.prevent="handleAction('share')"
			>
				Share
			</span>
			<span
				class="item"
				@mousedown.prevent="highlight()"
			>
				Highlight
			</span>
			<!-- more buttons here -->
		</div>
		<slot ref="mySlot"></slot>
	</div>
</template>

<script>
import axios from 'axios';
let selection;
let selectionRange;
let highlights = [];
export default {
	name: 'VueSelection',
	data () {
		return {
			x: 0,
			y: 0,
			showMenu: false,
			selectedText: ''
		}
	},
	computed: {
        highlightableEl () {
        return this.$refs.mySlot;
            }
        },
	mounted () {
        getAllHighlights();
		window.addEventListener('mouseup', this.onMouseup)
	},

	beforeDestroy () {
		window.removeEventListener('mouseup', this.onMouseup)
	},

	methods: {
		onMouseup () {
			selection = window.getSelection()
			selectionRange = selection.getRangeAt(0)
            this.x = selectionRange.startOffset;
            this.y = selectionRange.endOffset;

			// Get the x, y, and width of the selection
			const { x, y, width } = selectionRange.getBoundingClientRect()

			// If width === 0 (i.e. no selection)
			// Then, hide the menu
			if (!width) {
                console.log("in width")
				this.showMenu = false
				return
			}

			this.x = x + (width / 2)
			this.y = y + window.scrollY - 10
			this.selectedText = selection.toString()
			this.showMenu = true
		},
		handleAction (action) {
			this.$emit(action, this.selectedText)
		},
        highlight() {
            selection = window.getSelection()
			selectionRange = selection.getRangeAt(0)
            addHighlight(1, selectionRange.startOffset, selectionRange.endOffset);
            TestTextHighlighting(selectionRange.startOffset, selectionRange.endOffset);
        

        }

	},
}
function upTo(el, tagName) {
  tagName = tagName.toLowerCase();
  while (el && el.parentNode) {
    el = el.parentNode;
    if (el.tagName && el.tagName.toLowerCase() == tagName) {
      return el;
    }
  }

  // Many DOM methods return null if they don't 
  // find the element they are searching for
  // It would be OK to omit the following and just
  // return undefined
  return null;
}

function addHighlight(user_id, x, y) {
    let highlight = {"user_id":user_id,"start_offset":x,"end_offset":y};
    axios
                    .post('http://localhost:8000/highlight/add', highlight)
                    .then(response => (
                         console.log(response.data)
                    ))
                    .catch(error => console.log(error))
}

function getAllHighlights() {
        axios
                .get('http://localhost:8000/highlights')
                .then(response => {
                    highlights = response.data;
                    HighlightAll(highlights);
                });
}
var InstantSearch = {

"highlight": function (container, start_offset, end_offset)
{
    var internalHighlighter = function (options)
    {

        var id = {
            container: "container",
            tokens: "tokens",
            all: "all",
            className: "className",
            sensitiveSearch: "sensitiveSearch"
        },
        tokens = options[id.tokens],
        allClassName = options[id.all][id.className],
        allSensitiveSearch = options[id.all][id.sensitiveSearch];


        function checkAndReplace(node, tokenArr, classNameAll)
        {
            var nodeVal = node.nodeValue, parentNode = node.parentNode,
                i, j, curToken, myClassName,
                finalClassName,
                foundIndex, begin, matched, end,
                textNode, mark;

            for (i = 0, j = tokenArr.length; i < j; i++)
            {
                curToken = tokenArr[i];
                myClassName = curToken[id.className];

                finalClassName = (classNameAll ? myClassName + " " + classNameAll : myClassName);
                    
                    if (selectionRange.startContainer != selectionRange.endContainer)
                    {
                        if (node != selectionRange.startContainer && node != selectionRange.endContainer && !isFirst && isLast){
                            matched = nodeVal.substr(0, node.length);
                            mark = document.createElement("mark");
                            mark.className += finalClassName;
                            EndOffset+= node.length;
                            mark.appendChild(document.createTextNode(matched));
                            node.textContent = "";
                            parentNode.insertBefore(mark, node);
                        }
                        else if (node == selectionRange.startContainer)
                        {
                            isFirst = false;
                            begin = nodeVal.substring(0, start_offset);
                            matched = nodeVal.substr(start_offset, node.length);
                            node.textContent = "";
                            EndOffset+=node.length;
                            if (begin)
                            {
                                textNode = document.createTextNode(begin);
                                parentNode.insertBefore(textNode, node);
                            } // End if (begin)
                            mark = document.createElement("mark");
                            mark.className += finalClassName;
                            
                            mark.appendChild(document.createTextNode(matched));
                            parentNode.insertBefore(mark, node);
                        }
                        
                        else if (node == selectionRange.endContainer)
                        {
                            isLast = false;
                            matched = nodeVal.substr(selectionRange.endContainer.start_offset, end_offset);
                            mark = document.createElement("mark");
                            mark.className += finalClassName;
                            EndOffset+=end_offset;
                            mark.appendChild(document.createTextNode(matched));
                            nodeVal = nodeVal.substring(start_offset + (end_offset - start_offset));
                            node.textContent = nodeVal;
                            parentNode.insertBefore(mark, node);
                        }
                        break;
                    }
                    
                    else {
                        if (node != selectionRange.startContainer)
                        break;
                    }
                    begin = nodeVal.substring(0, start_offset);
                    matched = nodeVal.substr(start_offset, (end_offset - start_offset) );

                    if (begin)
                    {
                        textNode = document.createTextNode(begin);
                        parentNode.insertBefore(textNode, node);
                    } // End if (begin)
                    mark = document.createElement("mark");
                    mark.className += finalClassName;
                    mark.appendChild(document.createTextNode(matched));
                    nodeVal = nodeVal.substring(start_offset + (end_offset - start_offset));
                    node.textContent = nodeVal;
                    parentNode.insertBefore(mark, node);
   

            } // Next i 
        }; // End Function checkAndReplace 

       

        function iterator(p)
        {
            if (p === null) return;
    
            var children = Array.prototype.slice.call(p.childNodes), i, cur;

            if (children.length)
            {
                
                for (i = 0; i < children.length; i++)
                {
                    cur = children[i];
                    if (cur.nodeType === 3)
                    {
                        checkAndReplace(cur, tokens, allClassName, allSensitiveSearch);
                    }
                    else if (cur.nodeType === 1)
                    {
                        iterator(cur);
                    }
                }
            }
        }; // End Function iterator

        iterator(options[id.container]);
    } // End Function highlighter
    ;


    internalHighlighter(
        {
            container: container
            , all:
                {
                    className: "highlighter"
                }
            , tokens: [
                {
                    className: "highlight"
                    , sensitiveSearch: false
                }
            ]
        }
    ); // End Call internalHighlighter 

} // End Function highlight

};
let StartOffset;
        let EndOffset;
        let isFirst;
        let isLast;
function TestTextHighlighting(start_offset, end_offset)
{
    StartOffset = 0;
    EndOffset = 0;
    isFirst = true;
    isLast = true;
    var container = document.getElementById("wholeText");
    InstantSearch.highlight(container, start_offset, end_offset);
}

function HighlightAll(Highlights)
{
    var container = document.getElementById("wholeText");
    Highlights.forEach(highlight => {
        InstantSearch.highlight(container, highlight.start_offset, highlight.end_offset);
    });
}



</script>

<style>
.popover {
	height: 30px;
	padding: 5px 10px;
	background: #333;
	border-radius: 3px;
	position: absolute;
	top: 0;
	left: 0;
	transform: translate(-50%, -100%);
	transition: 0.2s all;
	display: flex;
	justify-content: center;
	align-items: center;
	/* opacity */
	opacity: 0.9;
}

.popover:after {
	content: '';
	position: absolute;
	left: 50%;
	bottom: -5px;
	transform: translateX(-50%);
	width: 0;
	height: 0;
	border-left: 6px solid transparent;
	border-right: 6px solid transparent;
	border-top: 6px solid #333;
}

.item {
	/* text (or icon) color before hovering */
	color: #FFF;
	cursor: pointer;
}

.item:hover {
	/* text (or icon) hover color */
	color: #ff69b4;
}

.item + .item {
	margin-left: 10px;
}
</style>
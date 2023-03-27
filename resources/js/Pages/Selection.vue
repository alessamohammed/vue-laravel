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
            console.log(this.$slots);
            console.log(this.$slots.default[0]);
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
			// startNode is the element that the selection starts in
            console.log(selectionRange);
			const startNode = upTo(selectionRange.startContainer,"div")
			// endNode is the element that the selection ends in
			const endNode = upTo(selectionRange.endContainer,"div")

            
			// if the selected text is not part of the highlightableEl (i.e. <p>)
			// OR
			// if startNode !== endNode (i.e. the user selected multiple paragraphs)
			// Then
			// Don't show the menu (this selection is invalid)
            // ! startNode.isSameNode(this.highlightableEl) ||
			if (!startNode.isSameNode(endNode)) {
                console.log(!startNode.isSameNode(this.highlightableEl));
                console.log(!startNode.isSameNode(endNode))
                console.log("in the same node")
				this.showMenu = false
				return
			}

			// Get the x, y, and width of the selection
			const { x, y, width } = selectionRange.getBoundingClientRect()

			// If width === 0 (i.e. no selection)
			// Then, hide the menu
			if (!width) {
                console.log("in width")
				this.showMenu = false
				return
			}

			// Finally, if the selection is valid,
			// set the position of the menu element,
			// set selectedText to content of the selection
			// then, show the menu
			this.x = x + (width / 2)
			this.y = y + window.scrollY - 10
			this.selectedText = selection.toString()
			this.showMenu = true
		},
		handleAction (action) {
			this.$emit(action, this.selectedText)
		},
        highlight() {
            // var inputText = document.getElementById("wholeText");
            // var innerHTML = inputText.innerHTML;
            // let innerText = inputText.innerText
            // let start;
            // let end;
            // if (start > end)
            // {
            //     start = selectionRange.endOffset;
            //     end = selectionRange.startOffset;
            // }
            // else
            // {
            // start = selectionRange.startOffset;
            // end = selectionRange.endOffset;
            // }
            // console.log(selectionRange.startContainer);
            // innerHTML = innerText.substring(0,start) + "<mark>" + innerText.substring(start,end) + "</mark>" + innerText.substring(end,);
            // inputText.innerHTML = innerHTML;

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
                    console.log(response.data);
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
            console.log(node);
            console.log("in check and replace")
            var nodeVal = node.nodeValue, parentNode = node.parentNode,
                i, j, curToken, myClassName,
                finalClassName,
                foundIndex, begin, matched, end,
                textNode, mark, isFirst;

                console.log(tokenArr);
            for (i = 0, j = tokenArr.length; i < j; i++)
            {
                curToken = tokenArr[i];
                myClassName = curToken[id.className];

                finalClassName = (classNameAll ? myClassName + " " + classNameAll : myClassName);


                // isFirst = true;
       
                                       
                //     if (parentNode == selectionRange.startContainer.parentElement)
                //     {
                //         foundIndex = start_offset;
                //         console.log(foundIndex);
                //     }
                //     else
                //     foundIndex = -1;

                //     if (foundIndex < 0)
                //     {
                //         if (isFirst)
                //             break;

                //         if (nodeVal)
                //         {
                //             textNode = document.createTextNode(nodeVal);
                //             console.log("textnode nodeval", textNode)
                //             parentNode.insertBefore(textNode, node);
                //         } // End if (nodeVal)

                //         parentNode.removeChild(node);
                //         break;
                //     } // End if (foundIndex < 0)

                //     isFirst = false;


                    begin = nodeVal.substring(0, foundIndex);
                    matched = nodeVal.substr(foundIndex, (end_offset - start_offset) );

                    if (begin)
                    {
                        textNode = document.createTextNode(begin);
                        console.log("textNode begin", textNode)
                        parentNode.insertBefore(textNode, node);
                    } // End if (begin)
                    mark = document.createElement("mark");
                    mark.className += finalClassName;
                    console.log(matched);
                    mark.appendChild(document.createTextNode(matched));
                    nodeVal = nodeVal.substring(foundIndex + (end_offset - start_offset));
                    console.log(nodeVal);
                    node.textContent = nodeVal;
                    console.log(node);
                    parentNode.insertBefore(mark, node);

                    console.log(nodeVal);
   

            } // Next i 
        }; // End Function checkAndReplace 

        function iterator(p)
        {
            if (p === null) return;
    
            var children = Array.prototype.slice.call(p.childNodes), i, cur;
            console.log(children);
            if (children.length)
            {
                for (i = 0; i < children.length; i++)
                {
                    cur = children[i];
                    console.log(cur)
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

function TestTextHighlighting(start_offset, end_offset)
{
    console.log("in testtexthighlighting")
    var container = document.getElementById("wholeText");
    InstantSearch.highlight(container, start_offset, end_offset);
}

function HighlightAll(Highlights)
{
    console.log("in testtexthighlighting")
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
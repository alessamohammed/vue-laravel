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
let selection;
let selectionRange;
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
		window.addEventListener('mouseup', this.onMouseup)
	},

	beforeDestroy () {
		window.removeEventListener('mouseup', this.onMouseup)
	},

	methods: {
		onMouseup () {
			selection = window.getSelection()
			selectionRange = selection.getRangeAt(0)
            console.log(selection)
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
            TestTextHighlighting("Vue");

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

var InstantSearch = {

"highlight": function (container, highlightText)
{
    var internalHighlighter = function (options)
    {

        var id = {
            container: "container",
            tokens: "tokens",
            all: "all",
            token: "token",
            className: "className",
            sensitiveSearch: "sensitiveSearch"
        },
        tokens = options[id.tokens],
        allClassName = options[id.all][id.className],
        allSensitiveSearch = options[id.all][id.sensitiveSearch];


        function checkAndReplace(node, tokenArr, classNameAll, sensitiveSearchAll)
        {
            console.log(node);
            console.log("in check and replace")
            var nodeVal = node.nodeValue, parentNode = node.parentNode,
                i, j, curToken, myToken, myClassName, mySensitiveSearch,
                finalClassName, finalSensitiveSearch,
                foundIndex, begin, matched, end,
                textNode, mark, isFirst;

                console.log(tokenArr);
            for (i = 0, j = tokenArr.length; i < j; i++)
            {
                curToken = tokenArr[i];
                myToken = curToken[id.token];
                myClassName = curToken[id.className];
                mySensitiveSearch = curToken[id.sensitiveSearch];

                finalClassName = (classNameAll ? myClassName + " " + classNameAll : myClassName);

                finalSensitiveSearch = (typeof sensitiveSearchAll !== "undefined" ? sensitiveSearchAll : mySensitiveSearch);

                isFirst = true;
       
                    // if (finalSensitiveSearch)
                    //     foundIndex = nodeVal.indexOf(myToken);
                    // else
                    //     foundIndex = nodeVal.toLowerCase().indexOf(myToken.toLowerCase());
                    console.log(parentNode,selectionRange.startContainer.parentElement);
                    
                    if (parentNode == selectionRange.startContainer.parentElement)
                    {
                        foundIndex = selectionRange.startOffset;
                        console.log(foundIndex);
                    }
                    else
                    foundIndex = -1;

                    if (foundIndex < 0)
                    {
                        if (isFirst)
                            break;

                        if (nodeVal)
                        {
                            textNode = document.createTextNode(nodeVal);
                            console.log("textnode nodeval", textNode)
                            parentNode.insertBefore(textNode, node);
                        } // End if (nodeVal)

                        parentNode.removeChild(node);
                        break;
                    } // End if (foundIndex < 0)

                    isFirst = false;


                    begin = nodeVal.substring(0, foundIndex);
                    matched = nodeVal.substr(foundIndex, (selectionRange.endOffset - selectionRange.startOffset) );

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
                    nodeVal = nodeVal.substring(foundIndex + (selectionRange.endOffset - selectionRange.startOffset));
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
                    token: highlightText
                    , className: "highlight"
                    , sensitiveSearch: false
                }
            ]
        }
    ); // End Call internalHighlighter 

} // End Function highlight

};

function TestTextHighlighting(highlightText)
{
    console.log("in testtexthighlighting")
    var container = document.getElementById("wholeText");
    InstantSearch.highlight(container, highlightText);
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
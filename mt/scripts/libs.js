function dumpobj(obj)
{
	content = "<strong>" + obj + "</strong><br />\n";
	for(var i in obj)
	{
		content += obj + "." + i + " = " + obj[i] + "<br />\n";
		for(var j in obj[i])
		{
			content += obj + "." + i + "." + j + " = " + obj[i][j] + "<br />\n";
		}
	}
	
	message(content);
}

function deleteParent(element)
{
	if(!isset(element))
	{
		element = this;
	}
	
	var parent = element.parentNode;
	var grandparent = parent.parentNode;
	
	if(grandparent != null)
	{
		grandparent.removeChild(parent);
	}
}

function removeElement(element)
{
	element.parentNode.removeChild(element);
}

function getPos(element)
{
	var coords = {};
	coords['x'] = 0;
	coords['y'] = 0;
	
	do {
		coords['x'] += element.offsetLeft;
		coords['y'] += element.offsetTop;
	} while(element = element.offsetParent);
	
	return coords;
}

function setPos(element, x, y)
{
	element.style.left = x + "px";
	element.style.top = y + "px";
}

function isset(obj)
{
	return obj != null && obj != undefined;
}

function include(url)
{
	document.write("	<script type=\"text/javascript\" src=\"scripts/" + url + "\"></script>");
}

function createButton(img, alt, func)
{
	var button = document.createElement("img");
	button.src = "images/" + img + ".png";
	button.alt = alt;
	button.title = alt;
	button.style.cursor = "pointer";

	if(isset(func))
	{
		$(button).bind("click", func);
	}
	
	return button;	
}

function createRemoveButton(func)
{
	return createButton("remove", "Remove", func);
}

function createEditButton(func)
{
	return createButton("edit", "Edit", func);
}

function createAddButton(func)
{
	return createButton("add", "Add", func);
}

function createContainer(className, contents)
{
	var container = document.createElement("div");
	$(container).addClass(className);
	
	if(isElement(contents))
	{
		$(container).append(contents);
	}
	else if(isset(contents))
	{
		container.innerHTML = contents;
	}
	
	return container;
}

function createTitle(text, className)
{
	var title = createContainer("title", text);
	if(isset(className))
	{
		$(title).addClass(className);
	}
	return title;
}

function message(content)
{
	var div = document.createElement("div");
	$(div).addClass("flora");
	$(document).append(div);
	$(div).append(content);
	
	//Destroy on close
	var func = function (event, popin) { $(popin).dialog("destroy"); };
	
	$(div).dialog({ 
    modal: true, 
	autoOpen: true,
	stack: true,
	close: func,
    overlay: { 
        opacity: 0.5, 
        background: "black"
    }});
}

function isElement (element)
{
	return isset(element) && isset(element.nodeType);
}

function isString (string)
{
	return (typeof string == "string");
}

function call(func, context)
{
	var args = argToArray(arguments);
	
	//Remove the context and func
	args.shift();
	args.shift();
	
	if(isset(context))
	{
		return function ()
		{
			var args2 = argToArray(arguments);
			var allArgs = args.concat(args2);
			
			if(isset(func))
			{
				func.apply(context, allArgs);
			}
		}
	}
	else
	{
		return func;
	}
}

function argToArray(args)
{
	var ret = Array();
	
	for(var i = 0; i < args.length; i++)
	{
		ret.push(args[i]);
	}
	
	return ret;
}

function hide(element)
{
	$(element).hide("fadeOut");
}

function show(element)
{
	$element.show("fadeIn");
}

function createLink(contents, func)
{
	var link = document.createElement("a");
	
	if(isElement(contents))
	{
		$(link).append(contents);
	}
	else
	{
		link.innerHTML = contents;
	}
	
	if(isset(func))
	{
		$(link).bind("click", func);
	}
	
	addHover(link);
	
	return link;
}

function addHover(element)
{
	$(element).hover(
		function() 
		{
			$(element).addClass('hover');
		}, 
		function() 
		{
			$(element).removeClass('hover');
		});
}


include("libs/widget.js");
include("libs/forms.js");
include("libs/queries.js");
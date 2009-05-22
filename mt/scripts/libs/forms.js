//Functions	
function addOptionItem(selectbox, item, value)
{
	if(item != null && item.toString != null)
	{
		var option = document.createElement("option");
		option.text = item.toString();
		
		if(value != null)
		{
			option.value = value.toString();
		}
		
		selectbox.options.add(option);
	}
}

function createSelectBox(items, values)
{
	var selectBox = document.createElement("select");

	for(var i = 0; i < items.length; i++)
	{
		addOptionItem(selectBox, items[i], values[i]);
	}
	return selectBox;
}

function resetFormId() //Takes any number of args
{
	for(var i = 0; i < arguments.length; i++)
	{
		resetForm(document.getElementById(arguments[i]));
	}
}

function lockField(lock, element)
{
	if(isset(element))
	{
		element.disabled = lock;
	}
}

function lockForm(lock, elements)
{
	for(var i = 1; i < elements.length; i++)
	{
		elements[i].disabled = lock;
	}
}

function resetForm() //Takes any number of args
{
	for(var i = 0; i < arguments.length; i++)
	{
		var input = arguments[i];
		if(input.type == "checkbox")
		{
			input.checked = false;
		}
		else if(input.type == "select")
		{
			input.selectedIndex = 0;
		}
		else if(input.type == "text" ||
				input.type == "textarea" ||
				input.type == "password")
		{
			input.value = "";
		}
	}
}

function createSuggestBox(input)
{
	var popin = document.createElement("div");
	addClass(popin, "suggestBox");
	popin.style.position = "absolute";
	
	var coords = getPos(input);
	var x = coords.x;
	var y = coords.y + input.offsetHeight;
	setPos(popin, x, y);

	hideElement(popin);
	
	eventListener(input, "keyup", function()
	{
		var coords = getPos(input);
		var x = coords.x;
		var y = coords.y + input.offsetHeight;
	
		setPos(popin, x, y);
		showElement(popin);
	});
	
	eventListener(input, "blur", function ()
	{
		setTimeout(function ()
		{
			hideElement(popin);
		}
		, 250);
	});
	
	return popin;
}

function createInput(type, value, func)
{
	switch (type)
	{
		case "textarea":
			var input = document.createElement("textarea");
			input.innerHTML = value;
			break;
		
		case "select":
			var input = document.createElement("select");
			break;
			
		case "checkbox":
			var input = document.createElement("input");			
			input.type = "checkbox";
			
			//IE Bug...
			var span = document.createElement("span");
			span.appendChild(input);

			if(isset(value))
			{
				if(value == "t")
				{
					value = true;
				}
				else if (value == "f")
				{
					value = false;
				}

				input.checked = value;
			}
			break;
			
		case "numeric":
			var input = document.createElement("input");
			
			input.type = "text";
			input.size = 10;
			
			if(isset(value))
			{
				input.value = value;
			}
			
			$(input).bind("keyup", call(function (element)
			{
				var newvalue = "$";
							
				for(var i in element.value)
				{
					if(isNumber(i))
					{
						newvalue += "" + i;
					}
				}
				
				//element.value = newvalue;
			}, this, input));
			
			$(input).addClass("number-input");
			
			break;
		
		default:
			var input = document.createElement("input");

			input.type = type;

			if(isset(value))
			{
				input.value = value;
			}
			break;
	}
	
	if(isset(func))
	{
		$(input).bind("click", func);
	}
	
	return input;
}

function createLabel(name)
{
	var label = document.createElement("label");
	label.innerHTML = name;
	
	return label;
}

function createInputControl(element, status, parent)
{
	if(!isset(status))
	{
		status = false;
	}
	
	var control = createInput("checkbox", status);
	lockForm(!control.checked, Array(element));
	
	eventListener(control, "click", function ()
	{
		lockForm(!control.checked, Array(element));

		if(element.type == "select-one")
		{
			element.selectedIndex = 0;
		}
	});
	
	if(isset(parent))
	{
		parent.appendChild(control);
		parent.appendChild(element);
	}
	
	return control;
}

function findSelectIndex(selectBox, value)
{
	for(var i = 0 ; i < selectBox.options.length; i++)
	{
		if(selectBox.options[i].value == value)
		{
			return i;
		}
	}
	
	return false;
}

function addUniqueOptionItem(selectBox, name, value)
{
	if(findSelectIndex(selectBox, value) === false)
	{
		addOptionItem(selectBox, name, value);
	}
}

function selectOptionValue(selectBox, value)
{
	selectBox.selectedIndex = findSelectIndex(selectBox, value);
}

function createCalendar()
{
	var input = createInput("text", "mm/dd/yyyy");
	input.name = "date";
	input.id = "date";
	input.size = 8;
	input.maxlength = 10;
	
	var options = {};
	options.showAnim = "fadeIn";
	
	$(input).datepicker(options);
	
	return input;
}

function isValidDate(strDate)
{
	var validformat=/^\d{1,2}\/\d{1,2}\/\d{4}$/; //Basic check for format validity
	if (!validformat.test(strDate))
	{
      return false;
	}
	else
    {
		//December shows up as 00 instead of 12
		var monthfield=strDate.split("/")[0] % 12;
		var dayfield=strDate.split("/")[1];
		var yearfield=strDate.split("/")[2];

		var dayobj = new Date(yearfield, monthfield, dayfield);

		if ((dayobj.getMonth()!=monthfield)
			||(dayobj.getDate()!=dayfield)
			||(dayobj.getFullYear()!=yearfield))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

function isNumber(num)
{
	if(num == "")
	{
		return false;
	}
	
	var validformat = /^\d*(\.\d*)?$/; //Basic check for format validity
	return validformat.test(num);
}

function lockFields(parent)
{
	$("input, select, textarea", parent).attr("disabled", true);
}

function unlockFields(parent)
{
	$("input, select, textarea", parent).attr("disabled", false);
}

function markInvalid(element)
{
	$(element).addClass("invalid");
	$(element).removeClass("valid");
}

function markValid(element)
{
	$(element).addClass("valid");
	$(element).removeClass("invalid");
}
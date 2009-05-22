function job (id, title, weight, avail, taken, selected)
{
	this.constructor = function ()
	{
		this.id = id;
		this.title = title;
		this.weight = Number(weight);
		this.avail = avail; /* Total slots availible for workers */
		this.taken = taken - (selected ? 1 : 0); /* Slots taken by workers already */
		this.selected = selected;
		this.locked = false;
		this.perma_locked = (this.taken >= this.avail) && !this.selected;
		this.element = createContainer("job");	
		this.spots_left = createContainer("job_spots_left");		
		this.link = createLink(title, call(this.clicked_link, this));
		
		$(this.link).append(this.spots_left);

		this.checkbox = createInput("checkbox", this.selected, call(this.clicked_box, this));
		
		if(this.perma_locked)
		{
			$(this.element).addClass("perma_locked");
			this.lock();
		}
		
		$(this.element).append(this.checkbox);
		$(this.element).append(this.link);
		addHover(this.element);
		
		this.set_selected(this.selected);
	}
	
	this.lock = function ()
	{
		/* Do not prevent the user from deselecting a job */
		if(!this.selected)
		{
			lockField(true, this.checkbox)
			this.locked = true;
		}
	}
	
	this.unlock = function ()
	{
		if(!this.perma_locked)
		{
			lockField(false, this.checkbox);
			this.locked = false;
		}
	}
	
	this.is_locked = function ()
	{
		return this.locked;
	}

	this.clicked_link = function ()
	{
		if(!this.checkbox.disabled)
		{
			this.checkbox.checked = !this.checkbox.checked;
		}
		
		this.clicked();
	}
	
	this.clicked_box = function ()
	{
		this.clicked();
	}
	
	this.clicked = function ()
	{
		this.set_selected(this.checkbox.checked);

		if(isset(this.click_func) && !this.is_locked())
		{
			this.click_func();
		}
	}
	
	this.set_selected = function (value)
	{
		this.selected = this.checkbox.checked = value;
		this.refresh();

		if(this.selected == true)
		{
			$(this.element).addClass("selected");
		}
		else
		{
			$(this.element).removeClass("selected");
		}
	}
	
	this.set_click_func = function (func)
	{
		this.click_func = func;
	}
	
	this.refresh = function ()
	{
		var spots_left = this.avail - this.taken - (this.selected ? 1 : 0);
		
		if(spots_left != 1)
		{
			this.spots_left.innerHTML = spots_left + " spots left";
		}
		else
		{
			this.spots_left.innerHTML = spots_left + " spot left";
		}
	}
	
	this.constructor();
}

function job_set (id, title)
{
	this.constructor = function ()
	{
		this.id = id;
		this.title = createTitle(title);
		this.locked = false;
		this.workload = 0;
		
		this.element = createContainer("job_set");
		$(this.element).append(this.title);
		
		$(this.element).bind("click", call(this.click_func, this));
		
		this.job = {};
	}
	
	this.add_job = function(id, title, weight, avail, taken, selected)
	{
		if(!isset(this.job[id]))
		{
			this.job[id] = new job(id, title, weight, avail, taken, selected);
			$(this.element).append(this.job[id].element);
			
			if(selected)
			{
				this.lock();
				this.workload += weight;
			}
			
			if(this.locked)
			{
				this.job[id].lock();
			}
		}
		
		return this.job[id];
	}
	
	this.remove_job = function(id)
	{
		var j = this.job[id];
		$(this.job[id].element).remove();
		this.job[id] = null;
		return j;
	}

	this.calc_workload = function ()
	{
		this.workload = 0;
		for(var id in this.job)
		{
			if(this.job[id].selected)
			{
				this.workload += this.job[id].weight;
			}
		}
	}
	
	this.lock = function()
	{
		for(var id in this.job)
		{
			this.job[id].lock();
		}
		this.locked = true;
		this.calc_workload();
	}
	
	this.unlock = function()
	{
		this.calc_workload();
		for(var id in this.job)
		{
			/* Do not unlock, if there is still a selected option */
			if(this.job[id].selected)
			{
				this.lock();
				return;
			}
			
			this.job[id].unlock();
		}
		this.locked = false;
	}
	
	this.click_func = function()
	{
		for(var id in this.job)
		{
			if(this.job[id].selected)
			{
				/* Found a selected item, we can safely lock everything */
				this.lock();
				return;
			}
		}
		this.unlock();
	}
	
	this.constructor(id, title);
}

function job_container(id, title)
{
	this.constructor = function(id, title)
	{
		this.id = id;
		this.title = createTitle(title);
		this.workload = 0;
		this.locked = false;
		
		this.element = createContainer("job_container");
		$(this.element).append(this.title);
		$(this.element).bind("click", call(this.clicked, this));
		
		this.job_set = {};
	}
	
	this.add_job_set = function(id, title)
	{	
		if(!isset(this.job_set[id]))
		{
			this.job_set[id] = new job_set(id, title);
			$(this.element).append(this.job_set[id].element);
			
			if(this.locked)
			{
				this.job_set[id].lock();
			}
		}
		
		return this.job_set[id];
	}
	
	this.clicked = function ()
	{
		this.calc_workload();
		
		if(this.locked)
		{
			this.lock();
		}
	}

	this.calc_workload = function ()
	{
		this.workload = 0;

		for(var id in this.job_set)
		{
			this.job_set[id].calc_workload();
			this.workload += this.job_set[id].workload;
		}
	}
	
	this.remove_job_set = function(id)
	{
		var js = this.job_set[id];
		$(this.job_set[id].element).remove();
		this.job_set[id] = null;
		return js;
	}
	
	this.lock = function ()
	{
		for(var id in this.job_set)
		{
			this.job_set[id].lock();
		}
		this.locked = true;
	}
	
	this.unlock = function ()
	{
		for(var id in this.job_set)
		{
			this.job_set[id].unlock();
		}
		this.locked = false;
	}
	
	this.constructor(id, title);
}

function event_container(id, name, motd, work_capacity, workload)
{
	this.constructor = function()
	{
		this.id = id;
		this.name = name;
		this.title = createTitle(name, "event_title");
		this.motd = createTitle(motd, "event_motd");
		this.capacity = Number(work_capacity);
		this.workload = Number(workload);
		this.workload_title = createTitle("", "event_workload_title");
		this.locked = false;
		this.element = createContainer("event_container");
		
		$(this.title).append(this.workload_title);
		$(this.element).append(this.title);
		$(this.element).append(this.motd);
		
		$(this.element).bind("click", call(this.clicked, this));
		
		this.job_container = {};
		this.update_title();
		
		if(this.workload >=	this.capacity)
		{
			this.lock();
		}
	}
	
	this.update_title = function ()
	{
		this.workload_title.innerHTML = " :: " + this.workload + " of " + this.capacity + " jobs chosen";
	}
	
	this.calc_workload = function ()
	{
		this.workload = 0;
		
		for(var id in this.job_container)
		{
			this.job_container[id].calc_workload();
			this.workload += this.job_container[id].workload;
		}
		
		this.update_title();
		
		if(this.workload >= this.capacity)
		{
			this.lock();
		}
		else if (this.locked)
		{
			this.unlock();
		}
		
		return this.workload;
	}
	
	this.clicked = function ()
	{
		this.calc_workload();
		if(this.locked)
		{
			this.lock();
		}
		
		if(isset(this.click_func))
		{
			this.click_func();
		}
	}
	
	this.set_click_func = function (func)
	{
		this.click_func = func;
	}
	
	this.set_title = function (title)
	{
		this.name.innerHTML = title;
	}
	
	this.add_job_container = function (id, title)
	{
		if(!isset(this.job_container[id]))
		{
			this.job_container[id] = new job_container(id, title);
			$(this.element).append(this.job_container[id].element);
			
			if(this.locked)
			{
				this.job_container[id].lock();
			}
		}
		
		return this.job_container[id];
	}
	
	this.remove_job_container = function(id)
	{
		var jc = this.job_container[id];
		$(this.job_container[id]).remove();
		this.job_container[id] = null;
		return jc;
	}
	
	this.lock = function ()
	{
		for(var id in this.job_container)
		{
			this.job_container[id].lock();
		}
		
		this.locked = true;
	}
	
	this.unlock = function ()
	{
		for(var id in this.job_container)
		{
			this.job_container[id].unlock();
		}
		
		this.locked = false;
	}

	this.constructor(id, name);
}

function event_item (id, name, role)
{
	this.constructor = function()
	{
		this.id = id;
		this.element = createLink("", call(this.clicked, this));
		this.name = createContainer("event_item_name", name);
		this.role = createContainer("event_item_role", role);
		
		$(this.element).append(this.name);
		$(this.element).append(this.role);
		addHover(this.element);
	}
	
	this.clicked = function ()
	{
		//$(this.element).addClass("selected");
		
		if(isset(this.click_func))
		{
			this.click_func();
		}
	}
	
	this.set_click_func = function (func)
	{
		this.click_func = func;
	}
	
	this.constructor();
}

function event_list ()
{
	this.constructor = function ()
	{
		this.element = createContainer("event_list", createTitle("Events"));
		this.event_item = {};
		$(this.element).bind("click", call(this.clicked, this));
	}
	
	this.add_event_item = function (id, name, role)
	{
		if(!isset(this.event_item[id]))
		{
			this.event_item[id] = {};
		}
		
		if(isset(this.event_item[id]) && !isset(this.event_item[id][role]))
		{
			this.event_item[id][role] = new event_item(id, name, role);
			$(this.element).append(this.event_item[id][role].element);
		}
		
		return this.event_item[id][role];
	}
	
	this.remove_event_item = function(id, role)
	{
		var ei = this.event_item[id][role];
		$(this.event_item[id][role].element).remove();
		this.event_item[id][role] = null;
		return ei;
	}
	
	this.constructor();
}

function role_item (role)
{
	this.constructor = function ()
	{
		this.role = role;
	}
	
	this.destory = function ()
	{
		$(this.element).remove();
	}
	
	this.constructor();
}

function role_list (roles)
{
	this.constructor = function ()
	{
		this.roles = {};
		for(var i in roles)
		{
			this.add_role(roles[i]);
		}
		
		this.element = createContainer("roles_list");
	}
	
	this.remove_role = function(role)
	{
		this.roles[role].destroy();
		this.roles[role] = null;
	}
	
	this.add_role = function (role)
	{
		if(!isset(this.roles[role]))
		{
			this.roles[role] = new role_item(role);
			$(this.element).append(this.roles[role]);
		}
		
		return this.roles[role];
	}
	
	this.set_remove_role_func(func)
	{
		this.remove_role_func = func;
	}
	
	this.set_add_role_func(func)
	{
		this.add_role_func = func;
	}
	
	this.constructor();
}

function user_info (id, name, event_name)
{
	this.constructor = function ()
	{
		this.id = id;
		this.name = name;
		this.title = this.name;// + " - " + this.roles + " - " + event_name;
		
		this.element = createContainer("user_info");
		
		this.dialog_options = 
			{
				title : this.title,
				width : 925,
				height : 350,
				modal: true, 
				overlay: {
					opacity: 0.5, 
					background: "black" 
				} 
			}
	}
	
	this.dialog = function ()
	{
		$(this.element).dialog(this.dialog_options);
	}	
	
	this.constructor();
}

function user_item (id, name, role, workload, max_workload)
{
	this.constructor = function ()
	{
		this.id = id;
		this.name = name;
		this.roles = createContainer("user_item_roles");
		this.workload = workload;
		this.max_workload = max_workload;
		
		this.element = createContainer("user_item");
		this.add_role(role);
		
		$(this.element).bind("click", call(this.clicked, this));
	}
	
	this.clicked = function ()
	{
		if(isset(this.click_func))
		{
			this.click_func();
		}
	}
	
	this.add_role = function (role)
	{
		$(this.roles).append(createContainer("user_item_role", role));
		this.refresh();
	}
	
	this.set_click_func = function (func)
	{
		this.click_func = func;
	}
	
	this.refresh = function ()
	{
		
		this.element.innerHTML  = this.name;
		this.element.innerHTML += " :: " + this.workload + " of " + this.max_workload + " jobs";
		$(this.element).append(this.roles);
	}
	
	this.constructor();
}

function user_list ()
{
	this.constructor = function ()
	{
		this.element = createContainer("user_list");
		this.users = {};
		this.title = createTitle("Users");
		
		$(this.element).bind("click", call(this.clicked, this));
		$(this.element).append(this.title);
	}
	
	this.clicked = function ()
	{
		if(isset(this.click_func))
		{
			this.click_func();
		}
	}
	
	this.set_click_func = function (func)
	{
		this.click_func = func;
	}
	
	this.add_user = function (id, name, role, workload, max_workload)
	{
		if(!isset(this.users[id]))
		{
			this.users[id] = new user_item(id, name, role, workload, max_workload);
			$(this.element).append(this.users[id].element);
		}
		else
		{
			this.users[id].add_role(role);
		}
		
		return this.users[id];
	}
	
	this.constructor();
}

function add_user ()
{
	this.constructor = function ()
	{
		this.element = createContainer("add_user");
		this.user_name = createInput("text");
		
		$(this.element).append(this.user_name);
		
		this.auto_complete_options = {
			url : "query.php5",
			matchContains: true,
			//mustMatch: true,
			extraParams: {
				call: "get_person",
				},
		}
		
		this.dialog_options = 
		{
			width : 925,
			height : 350,
			modal: true, 
			overlay: {
				opacity: 0.5, 
				background: "black" 
			} 
		}
		
		$(this.user_name).autocomplete(this.auto_complete_options);
		
	}
	
	this.dialog = function()
	{
		$(this.element).dialog(this.dialog_options);
	}
	
	this.constructor();
}

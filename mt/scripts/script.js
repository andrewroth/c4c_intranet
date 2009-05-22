include("libs/mt_evt_events.js");

/* Class */
function staff_role (viewer_info, event_info)
{
	this.user_info = viewer_info;
	this.event_info = event_info;

	this.event_id = event_info.event_id;
	this.name = event_info.event_name;
	this.workload = event_info.workload;
	this.max_workload = event_info.max_workload;

	this.constructor = function()
	{
		this.evt_container = new event_container(this.event_id, this.name, event_info.motd, event_info.max_workload, event_info.workload);
		this.element = this.evt_container.element;
		$(this.element).addClass("staff_panel");
		
		obj = {
			"event_id": this.event_info.event_id,
			"viewer_id" : this.user_info.viewer_id,
		};
		
		mt_api_call("get_jobs", obj, call(this.populate_event_container, this));
	}
	
	this.destroy = function ()
	{
		$(this.element).remove();
	}

	this.populate_event_container = function(data)
	{
		for(var i in data)
		{
			var row = data[i];
			
			if(isset(row.job_id))
			{
				var item = this.evt_container
					.add_job_container(row.container_id, row.container_name)
					.add_job_set(row.set_id, row.set_name)
					.add_job(row.job_id, row.job_name, row.job_weight, row.job_openings, row.job_filled, (row.signed_up == 1));
				
				item.set_click_func(call(this.job_clicked, this, row, item));
			}
		}
	}

	this.job_clicked = function(data, item)
	{
		$(item.element).addClass("sending");
		
		var obj = {
			"job_id" : data.job_id,
			"viewer_id" : this.user_info.viewer_id,
			};
		
		if(item.selected)
		{
			mt_api_call("pick_job", obj, call(this.item_sent, this, item));
		}
		else
		{
			mt_api_call("unpick_job", obj, call(this.item_sent, this, item));
		}
	}
	
	this.item_sent = function (item, data)
	{
		$(item.element).removeClass("sending");
		
		if(data == true)
		{
			$(item.element).addClass("sent");
		}
		else
		{
			alert("Unable to schedule you in this item.  Try again later.");
			$(item.element).addClass("error_sending");			
			item.set_selected(false);
			item.unlock();
		}
	}
	
	this.constructor();
}

function staff_edit (viewer_info, event_info)
{
	this.constructor = function()
	{
		this.viewer_info = viewer_info;
		this.event_info = event_info;
	
		this.user_info = new user_info(this.viewer_info.viewer_id,
										this.viewer_info.person_fname + " " + this.viewer_info.person_lname,
										this.viewer_info.event_name);
		this.element = this.user_info.element;
		$(this.element).addClass("staff_edit");
		
		this.evt_container = new event_container(this.viewer_info.event_id,
												this.viewer_info.event_name,
												this.event_info.motd,
												this.viewer_info.max_workload,
												this.viewer_info.workload);
		
		$(this.element).append(this.evt_container.element);
		
		obj = {
			"event_id": this.viewer_info.event_id,
			"viewer_id" : this.viewer_info.viewer_id,
		};
		
		mt_api_call("get_jobs", obj, call(this.populate_event_container, this, this.evt_container));
	}
	
	this.dialog = function ()
	{
		this.user_info.dialog();
	}
	
	this.destroy = function ()
	{
		$(this.evt_container.element).remove();
	}
	
	this.populate_event_container = function(evt_container, data)
	{
		for(var i in data)
		{
			var row = data[i];
			
			if(isset(row.job_id))
			{
				var item = this.evt_container
					.add_job_container(row.container_id, row.container_name)
					.add_job_set(row.set_id, row.set_name)
					.add_job(row.job_id, row.job_name, row.job_weight, row.job_openings, row.job_filled, (row.signed_up == 1));
				
				item.set_click_func(call(this.job_clicked, this, row, item));
			}
		}
	}
	
	this.job_clicked = function(data, item)
	{
		$(item.element).addClass("sending");
		
		var obj = {
			job_id : data.job_id,
			viewer_id : this.viewer_info.viewer_id,
			};
		
		if(item.selected)
		{
			mt_api_call("pick_job", obj, call(this.item_sent, this, item));
		}
		else
		{
			mt_api_call("unpick_job", obj, call(this.item_sent, this, item));
		}
	}
	
	this.item_sent = function (item, data)
	{
		$(item.element).removeClass("sending");
		
		if(data == true)
		{
			$(item.element).addClass("sent");
		}
		else
		{
			alert("Unable to schedule this item.  Try again later.");
			$(item.element).addClass("error_sending");			
			item.set_selected(false);
			item.unlock();
		}
	}
	
	this.constructor();
}

/* Class */
function admin_role(viewer_info, event_info)
{
	this.constructor = function ()
	{
		this.viewer_info = viewer_info;
		this.event_info = event_info;

		this.evt_container = new event_container(this.event_info.event_id,
												this.event_info.event_name,
												this.event_info.motd,
												0,
												0);
		
		this.user_list = new user_list();
		
		this.add_user_button = createLink("+ Add New User", call(this.add_user_clicked, this));
		$(this.user_list.element).append(this.add_user_button);

		this.element = createContainer("admin_panel");
		$(this.element).append(this.user_list.element);
		$(this.element).append(this.evt_container.element);
		
		var obj  = { "event_id" : event_info['event_id'] };
		mt_api_call("get_jobs", obj, call(this.populate_event_container, this, this.evt_container));
		mt_api_call("get_users", obj, call(this.populate_users, this));
	}

	this.destroy = function ()
	{
		$(this.user_list.element).remove();
		$(this.evt_container.element).remove();
	}
	
	this.populate_event_container = function(evt_container, data)
	{
		for(var i in data)
		{
			var row = data[i];
			
			var item = evt_container;
			
			if(isset(row.container_id))
			{
				item = item.add_job_container(row.container_id, row.container_name);
				//item.element.append(
			}
			
			if(isset(row.set_id))
			{
				item = item.add_job_set(row.set_id, row.set_name);
			}
			
			if(isset(row.job_id))
			{
				item = item.add_job(row.job_id, row.job_name, row.job_weight, row.job_openings, row.job_filled, (row.signed_up == 1));
			}
				
			if(isset(item.set_click_func))
			{
				item.set_click_func(call(this.job_clicked, this, row, item));
			}
		}
	}
	
	this.job_clicked = function(data, item)
	{
		$(item.element).addClass("sending");
		
		var obj = {
			"job_id" : data.job_id,
			"viewer_id" : data.viewer_id,
			};
		
		if(item.selected)
		{
			mt_api_call("pick_job", obj, call(this.item_sent, this, item));
		}
		else
		{
			mt_api_call("unpick_job", obj, call(this.item_sent, this, item));
		}
	}

	this.populate_users = function (data)
	{
		for(var i in data)
		{
			var row = data[i];
			
			var user = this.user_list.add_user(row.viewer_id, 
									row.person_fname + " " + row.person_lname, 
									row.role, 
									Number(row.workload), 
									row.max_workload);
			
			user.set_click_func(call(this.user_clicked, this, data[i]));
			addHover(user.element);
		}
	}
	
	this.user_clicked = function (row)
	{
		var s_edit = new staff_edit(row, this.event_info);
		$(this.element).append(s_edit.element);
		s_edit.dialog();
		return;
	}
	
	this.job_clicked = function(data, item)
	{
		$(item.element).addClass("sending");
		
		var obj = {
			"job_id" : data.job_id,
			"viewer_id" : item.viewer_id,
			};
		
		if(item.selected)
		{
	//		mt_api_call("pick_job", obj, call(this.item_sent, this, item));
		}
		else
		{
	//		mt_api_call("unpick_job", obj, call(this.item_sent, this, item));
		}
	}
	
	this.item_sent = function (item, data)
	{
		$(item.element).removeClass("sending");
		
		if(data == true)
		{
			$(item.element).addClass("sent");
		}
		else
		{
			alert("Unable to schedule you in this item.  Try again later.");
			$(item.element).addClass("error_sending");			
			item.set_selected(false);
			item.unlock();
		}
	}
	
	this.add_user_clicked = function(event_id)
	{
		var add_usr = new add_user();
		$(this.element).append(add_usr.element);
		//add_usr.dialog();
		
		this.constructor = function ()
		{
			this.event_id = event_id;
			
			//var staff = this.get_staff();
		}
		
		this.constructor();
	}
	
	this.constructor();
}

function create_admin_panel(event_info)
{
	if(isset(this.panel) && isset(this.panel.destroy))
	{	
		this.panel.destroy();
	}
	
	this.panel = new admin_role(this.viewer_info, event_info);
	$(this.container).append(this.panel.element);
}

function create_staff_panel(event_info)
{
	if(isset(this.panel) && isset(this.panel.destroy))
	{	
		this.panel.destroy();
	}
	
	this.panel = new staff_role(this.viewer_info, event_info);
	$(this.container).append(this.panel.element);
}

function populate_event_list(data)
{
	for(var i in data)
	{		
		var event_info = data[i];
		
		/* Function to call when an event is clicked on */
		func = function() {}; 
		
		switch(event_info.role)
		{
			case "Admin":
				func = create_admin_panel;
				break;
				
			case "Staff":
				func = create_staff_panel;
				break;
		}
		
		var item = this.event_list.add_event_item(
			event_info.event_id, 
			event_info.event_name, 
			event_info.role
			);	
		
		item.set_click_func(
			call(func, 
				this, 
				event_info
				)
			);
	}
}

function init()
{
	mt_api_call("who_am_i", {}, call(init2, this));
	
	$(document).ajaxError(function(event, request, settings)
		{
			alert("Error communicating with server.");
			location.reload(true);
		});
}

function init2 (my_info)
{
	this.viewer_info = my_info;
	this.event_list = new event_list();

	this.container = createContainer("mt_evt");
		
	obj = {"viewer_id": my_info.viewer_id};
	mt_api_call("get_events", obj, call(populate_event_list, this));
	
	$(this.container).append(this.event_list.element);
	$("#content").append(this.container);
	$("#content").append(createContainer("footer", "&nbsp;"));
}

$(init);
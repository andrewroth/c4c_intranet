
 
   function InitMenu()
   {
     var bar = menuBar.children     

     for(var i=0;i < bar.length;i++) 
        {
          var menu=eval(bar[i].menu)
          menu.style.visibility = "hidden"
          bar[i].onmouseover = new Function("ShowMenu("+bar[i].id+")")
          var Items = menu.children
          for(var j=0; j<Items.length; j++)
            {
              var menuItem = eval(Items[j].id)
                
                if(menuItem.menu != null)
                   { 
                    menuItem.innerHTML += "<Span Id="+menuItem.id+"_Arrow class='Arrow'>4</Span>"
                    //var tmp = eval(menuItem.id+"_Arrow")
                    // tmp.style.pixelLeft = menu.getBoundingClientRect().Right //- tmp.offsetWidth - 15
                    FindSubMenu(menuItem.menu)}
               
                 if(menuItem.cmd != null) 
                   {
                   menuItem.onclick = new Function("Do("+menuItem.id+")") } 
                   
              menuItem.onmouseover = new Function("highlight("+Items[j].id+")")
            
            }    
        
        }  
   }
   function FindSubMenu(subMenu)
   {
         var menu=eval(subMenu)
         var Items = menu.children
          for(var j=0; j<Items.length; j++)
            {
              menu.style.visibility = "hidden"
              var menuItem = eval(Items[j].id)
              
              
              if(menuItem.menu!= null)
                 {
                    menuItem.innerHTML += "<Span Id="+menuItem.id+"_Arrow class='Arrow'>4</Span>"
                    // var tmp = eval(menuItem.id+"_Arrow")
                    //tmp.style.pixelLeft = 35 //menuItem.getBoundingClientRect().right - tmp.offsetWidth - 15
                    FindSubMenu(menuItem.menu)
                 }

                 if(menuItem.cmd != null) 
                   {
                   menuItem.onclick = new Function("Do("+menuItem.id+")") } 
                  
              menuItem.onmouseover = new Function("highlight("+Items[j].id+")")
                 
            }  
   } 
   function ShowMenu(obj)
   {
     HideMenu(menuBar)
     var menu = eval(obj.menu)
     var bar = eval(obj.id)
     bar.className="barOver"
     menu.style.visibility = "visible"
     menu.style.pixelTop =  obj.getBoundingClientRect().top + obj.offsetHeight + Bdy.scrollTop
     menu.style.pixelLeft = obj.getBoundingClientRect().left + Bdy.scrollLeft
   }
   
   function highlight(obj)
   {
     var PElement = eval(obj.parentElement.id)
     if(PElement.hasChildNodes() == true)
     {  var Elements = PElement.children
       for(var i=0;i<Elements.length;i++)
       {
          TE = eval(Elements[i].id)
          TE.className = "menuItem"
       }
      } 
     obj.className="ItemMouseOver"
     window.defaultStatus = obj.title
     ShowSubMenu(obj)
   }
   
   function Do(obj)
   {
    var cmd = eval(obj).cmd	
    window.navigate(cmd)
     
   }
   
   function HideMenu(obj)
   {
          if(obj.hasChildNodes()==true)
              {  
                 var child = obj.children     
                 
                 for(var j =0;j<child.length;j++)
                  {
                     if (child[j].className=="barOver")
                     {var bar = eval(child[j].id)
                      bar.className="Bar"}
                      
                     if(child[j].menu != null)
                       {
                          var childMenu = eval(child[j].menu)
                          if(childMenu.hasChildNodes()==true) 
                               HideMenu(childMenu)
                          
                           childMenu.style.visibility = "hidden" 
                         }
                  }
              
              }
   }
  function ShowSubMenu(obj)
  {
     PMenu = eval(obj.parentElement.id)
      HideMenu(PMenu)
     if(obj.menu != null)
     {
     var menu = eval(obj.menu)
     menu.style.visibility = "visible"
     menu.style.pixelTop =  obj.getBoundingClientRect().top + Bdy.scrollTop
     menu.style.pixelLeft = obj.getBoundingClientRect().right + Bdy.scrollLeft
     if(menu.getBoundingClientRect().right > window.screen.availWidth )
       menu.style.pixelLeft = obj.getBoundingClientRect().left - menu.offsetWidth
    }
  } 





 ///////////////////CascadedDropdown Menu/////////////////
 //Date : 08/09/2001               						//
 //Version : 1.0        								//
 //Author Mr.Arun N Kumar	                            //
 //EMail: n_arunk@hotmail.com							//		
 /////////////////////////////////////////////////////////
 // Modifications on this code is not recomended
 // Suggestions are welcome

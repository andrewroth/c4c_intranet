//------------------------------------------------------------
function Camp_ReorderListBox( objListName) {
//
// DESCRIPTION
//	This function will sort the items in the list box.
//
//
// VARIABLES
	var objListBox = MM_findObj(objListName);
	var objSortedObject;
	var aListBox = new Array();
	var iItemCount;
	var iCount;
	var x;
	var y;
//
// PSEUDO CODE
//
// CODE
//
	if (objListBox)	{
		//get number of items in List Box
		iItemCount = objListBox.options.length;
		iCount = 0;
		
		//Iterate through the List Box.  Place Item Labels and Values into a
		//two-dimensional array.  Remove Items.
		for (x=0;x<iItemCount;x++) {
		    
		    aListBox[iCount] = new Array(2);
			aListBox[iCount][0]=objListBox.options[x].text;
			aListBox[iCount][1]=objListBox.options[x].value;
			//objListBox.options.remove(x);
			objListBox.options[x]=null;
			
			iCount++;
			--x;
			--iItemCount;
		}
		
//		//Sort array of items
		quicksort(0, iCount, aListBox);
		
		//Repopulate the List Box with the sorted array
		for (x=0;x<iCount;x++) {
			objSortedObject = document.createElement("OPTION");
			objSortedObject.text = aListBox[x][0];
			objSortedObject.value = aListBox[x][1];
			
			//objListBox.options.add(objSortedObject);
			objListBox.options[x]=objSortedObject;
		}
	}
}

// Swaps a[i], a[j] 
function swap(i, j, a)
{
	var t=a[i];
	a[i]=a[j];
	a[j]=t;
}

// Quick sort a[start..end-1]
function quicksort(start, end, a)
{
	if (end-start > 1)
	{
	
		var lastlow=start;
		for (var i=start+1; i<end; ++i)
		{
			if( a[i][0].toLowerCase()<a[start][0].toLowerCase() )
				swap(i, ++lastlow, a);
		}
		
		swap(start, lastlow, a);
		quicksort(start, lastlow, a);
		quicksort(lastlow+1, end, a);
	}
}

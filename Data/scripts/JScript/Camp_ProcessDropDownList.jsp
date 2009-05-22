function Camp_ProcessDropDownList(sel,mode,pagenum,chooser)

{

	sel.form.action = "stats.asp?M=" + mode + "&P=" + pagenum + "&C=" + chooser;

	sel.form.submit();

}


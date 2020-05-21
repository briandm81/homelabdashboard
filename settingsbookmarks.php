<?php
require_once('environment.php');
$bookmarks = spawnBookmarks();
//print_r($bookmarks);
?>

<div id="bookmark-table"></div>
<div style="display:none;" id="successSettingsBookmarkAlert">
		<div class="alert alert-success alert-dismissible fade show" role="alert" id="successSettingsBookmarkAlert2"><strong>Settings Saved!</strong> Please refresh the page to see changes.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
	</div>
	
	<div style="display:none;" id="dangerSettingsBookmarkAlert">
		<div class="alert alert-danger alert-dismissible fade show" role="alert" id="dangerSettingsBookmarkAlert2"><strong>Settings failed to save!</strong> Check the permissions on the SettingsBookmark.dat file (chmod 777).<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
	</div>
<div class="table-controls">
	<button type="button" class="btn btn-primary my-2 my-sm-0" id="headertitle" onclick="savebookmarks()">Save</button>
	<button id="add-row" class="btn btn-primary my-2 my-sm-0">Add Item</button>
	<button id="history-undo" class="btn btn-primary my-2 my-sm-0">Undo</button>
	<button id="history-redo" class="btn btn-primary my-2 my-sm-0">Redo</button>
</div>


<?php //echo json_encode($bookmarks); ?>

  <script>
	var tableBookmark = new Tabulator("#bookmark-table",{
	  layout:"fitDataFill",
	  movableRows:true,
	  addRowPos:"bottom",
	  history:true,
	  height:350,
	  columns:[
		{rowHandle:true, formatter:"handle", headerSort:false, frozen:true, width:30, minWidth:30},
		{title:"Name", field:"name",  headerSort:false, editor:"input", validator:["required", "unique"]},
		{title:"URL", field:"url", headerSort:false, editor:"input"},
		{title:"Image", field:"image", headerSort:false, editor:"input"},
		{title:"Icon", field:"icon", headerSort:false, editor:"input"},
		{title:"iFrame", field:"isIframe", headerSort:false, align:"center", formatter:"tickCross", width:70, minWidth:70, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Divider", field:"isDivider", headerSort:false, align:"center", formatter:"tickCross", width:70, minWidth:70, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Heading", field:"isHeading", headerSort:false, align:"center", formatter:"tickCross", width:80, minWidth:80, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Collapsed", field:"isCollapsed", headerSort:false, align:"center", formatter:"tickCross", width:90, minWidth:90, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Collapse Header", field:"isCollapseHeader", headerSort:false, align:"center", formatter:"tickCross", width:130, minWidth:130, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Collapse Item", field:"isCollapseItem", headerSort:false, align:"center", formatter:"tickCross", width:120, minWidth:120, cellClick:function(e, cell){
					
					if (cell.getValue() == null) {
						cell.setValue("true");	
					}
					else if (cell.getValue() == 1 || cell.getValue() == 'true') {
						cell.setValue("false");	
					}
					else {
						cell.setValue("true");	
					}
					}},
		{title:"Delete", field:"dekete", headerSort:false, align:"center", width:70, minWidth:70, formatter:"buttonCross", cellClick: function(e, cell) {
				cell.getRow().deselect();
				tableBookmark.deleteRow(cell.getRow());
				}},
	  ],
	});

	var tableData = <?php echo json_encode($bookmarks); ?>;

	$("#add-row").click(function(){
		tableBookmark.addRow({url:"",icon:"",image:"",isIframe:"false",isDivider:"false",isHeading:"false",isCollapsed:"false",isCollapseHeader:"false",isCollapseItem:"false"});
	});

	//undo button
	$("#history-undo").on("click", function(){
	   tableBookmark.undo();
	});

	//redo button
	$("#history-redo").on("click", function(){
		tableBookmark.redo();
	});

	tableBookmark.setData(tableData);

	$(window).resize(function(){
	  $("#bookmark-table").tabulator("redraw");
	});

    
	function savebookmarks()
	{
		var data = tableBookmark.getData();
		var text = "";
        for (index = 0; index < data.length; index++)
        {
            text+= "[" + data[index].name + "]\n" +
                    "url=" + data[index].url + "\n" +
                    "icon=" + data[index].icon + "\n" +
					"image=" + data[index].image + "\n" +
                    "isIframe=" + data[index].isIframe + "\n" +
                    "isDivider=" + data[index].isDivider + "\n" +
                    "isHeading=" + data[index].isHeading + "\n" +
                    "isCollapsed=" + data[index].isCollapsed + "\n" +
                    "isCollapseHeader=" + data[index].isCollapseHeader + "\n" +
                    "isCollapseItem=" + data[index].isCollapseItem + "\n\n";
        }
		$("#successSettingsBookmarkAlert").css("display", "none");
		$("#dangerSettingsBookmarkAlert").css("display", "none");
		$.ajax({
			type: "POST",
			url: "savebookmarks.php",
			data: {bookmarks:text},
			success: function(response) {
				if (response=="true") {
					if($("#successSettingsBookmarkAlert").find("div#successSettingsBookmarkAlert2").length==0){
						$("#successSettingsBookmarkAlert").append("<div class='alert alert-success alert-dismissible fade show' role='alert' id='successSettingsBookmarkAlert2'><strong>Settings Saved!</strong> Please refresh the page to see changes.<button type='button'class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
					}
					$("#successSettingsBookmarkAlert").css("display", "");
				}
				else {
					if($("#dangerSettingsBookmarkAlert").find("div#dangerSettingsBookmarkAlert2").length==0){
						$("#dangerSettingsBookmarkAlert").append("<div class='alert alert-success alert-dismissible fade show' role='alert' id='dangerSettingsBookmarkAlert2'><strong>Settings failed to save!</strong> Check the permissions on the settingsgeneral.dat file (chmod 777).<button type='button'class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
					}
					$("#dangerSettingsBookmarkAlert").css("display", "");
				}
			}
					
			
		});
        
    }
  </script>
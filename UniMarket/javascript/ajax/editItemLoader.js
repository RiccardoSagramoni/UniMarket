// OGGETTO EditItemLoader:
// utilizzato per filtrare attraverso un pattern i prodotti da modificare
// all'interno del portale per amministratori
function EditItemLoader(){}

EditItemLoader.DEFAUL_METHOD = "GET";
EditItemLoader.URL_REQUEST = "./../ajax/editItemLoader.php";
EditItemLoader.ASYNC_TYPE = true;

EditItemLoader.ITEM_TO_LOAD = 25;
EditItemLoader.CURRENT_PAGE_INDEX = 1;

EditItemLoader.SUCCESS_RESPONSE = "0";
EditItemLoader.NO_MORE_DATA = "-1";

EditItemLoader.init = 
	function() {
		EditItemLoader.PAGE_INDEX = 1;
	}

EditItemLoader.loadData =
	function(pattern = null){
		var queryString = "?itemsToLoad=" + EditItemLoader.ITEM_TO_LOAD 
							+ "&offset=" + (EditItemLoader.CURRENT_PAGE_INDEX-1)*EditItemLoader.ITEM_TO_LOAD;
		
		if(pattern !== null){
			queryString += ("&pattern=" + pattern);
		}
		
		var url = EditItemLoader.URL_REQUEST + queryString;
		var responseFunction = EditItemLoader.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(EditItemLoader.DEFAUL_METHOD, 
										url, EditItemLoader.ASYNC_TYPE, 
										null, responseFunction);
	}

EditItemLoader.next =
	function(pattern = null){
		scrollTo(0,0);
		EditItemLoader.CURRENT_PAGE_INDEX++;
		EditItemLoader.loadData(pattern);
	}
	
EditItemLoader.previous = 
	function(pattern = null){
		scrollTo(0,0);
		EditItemLoader.CURRENT_PAGE_INDEX--;
		if (EditItemLoader.CURRENT_PAGE_INDEX <= 1)
			EditItemLoader.CURRENT_PAGE_INDEX = 1;
		
		EditItemLoader.loadData(pattern);
	}
	
EditItemLoader.search =
	function(pattern){
		if (pattern.length === 0 || pattern === ''){
			pattern = null;
		}
		EditItemLoader.loadData(pattern);		
	}
	
EditItemLoader.onAjaxResponse = 
	function(response){
		if (response.responseCode === EditItemLoader.NO_MORE_DATA 
		 	&&	EditItemLoader.CURRENT_PAGE_INDEX === 1){
				
				EditItemDashboard.removeContent();
				ItemDashboard.updateNavigationPage(EditItemLoader.CURRENT_PAGE_INDEX,	true);
				return;
		}
		
		if (response.responseCode === EditItemLoader.SUCCESS_RESPONSE)
			EditItemDashboard.refreshData(response.data);
		
		var noMoreDataExist = (response.data === null || response.data.length < EditItemLoader.ITEM_TO_LOAD);
		ItemDashboard.updateNavigationPage(EditItemLoader.CURRENT_PAGE_INDEX, noMoreDataExist);
		
	}

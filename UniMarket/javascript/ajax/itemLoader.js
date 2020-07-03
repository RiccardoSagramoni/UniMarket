// OGGETTO ItemLoader:
// utilizzato per gestire dinamicamente la connessione AJAX con il server
// relativamente alla ricerca di prodotti di una data categoria
function ItemLoader(){}

ItemLoader.DEFAUL_METHOD = "GET";
ItemLoader.URL_REQUEST = "./ajax/ItemLoader.php";
ItemLoader.ASYNC_TYPE = true;

ItemLoader.ITEM_TO_LOAD = 20;
ItemLoader.CURRENT_PAGE_INDEX = 1;

ItemLoader.SUCCESS_RESPONSE = "0";
ItemLoader.NO_MORE_DATA = "-1";

ItemLoader.init = 
	function() {
		ItemLoader.PAGE_INDEX = 1;
	}

ItemLoader.loadData =
	function(categoryToSearch, pattern = null){
		var queryString = "?categoryToSearch=" + categoryToSearch + "&itemsToLoad=" + ItemLoader.ITEM_TO_LOAD 
							+ "&offset=" + (ItemLoader.CURRENT_PAGE_INDEX-1)*ItemLoader.ITEM_TO_LOAD;
		if(pattern !== null){
			queryString += ("&pattern=" + pattern);
		}
		
		var url = ItemLoader.URL_REQUEST + queryString;
		var responseFunction = ItemLoader.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(ItemLoader.DEFAUL_METHOD, 
										url, ItemLoader.ASYNC_TYPE, 
										null, responseFunction);
	}

ItemLoader.next =
	function(categoryToSearch, pattern = null){
		scrollTo(0,0);
		ItemLoader.CURRENT_PAGE_INDEX++;
		ItemLoader.loadData(categoryToSearch, pattern);
	}
	
ItemLoader.previous = 
	function(categoryToSearch, pattern = null){
		scrollTo(0,0);
		ItemLoader.CURRENT_PAGE_INDEX--;
		if (ItemLoader.CURRENT_PAGE_INDEX <= 1)
			ItemLoader.CURRENT_PAGE_INDEX = 1;
		
		ItemLoader.loadData(categoryToSearch, pattern);
	}

ItemLoader.search =
	function(categoryToSearch, pattern){
		if (pattern.length === 0 || pattern === ''){
			pattern = null;
		}
		ItemLoader.CURRENT_PAGE_INDEX = 1;
		ItemLoader.loadData(categoryToSearch, pattern);		
	}
	
ItemLoader.onAjaxResponse = 
	function(response){
		if (response.responseCode === ItemLoader.NO_MORE_DATA 
		 	&&	ItemLoader.CURRENT_PAGE_INDEX === 1){
			
				ItemDashboard.setEmptyDashboard(response.message);
				ItemDashboard.updateNavigationPage(ItemLoader.CURRENT_PAGE_INDEX,	true);
				return;
		}
		
		if (response.responseCode === ItemLoader.SUCCESS_RESPONSE)
			ItemDashboard.refreshData(response.data);
		
		var noMoreDataExist = (response.data === null || response.data.length < ItemLoader.ITEM_TO_LOAD);
		ItemDashboard.updateNavigationPage(ItemLoader.CURRENT_PAGE_INDEX, noMoreDataExist);
		
	}

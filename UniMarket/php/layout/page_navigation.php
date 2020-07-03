<!-- ELEMENTO DI NAVIGAZIONE TRA DIVERSE PAGINE -->
<nav class="page_navigation">
	<input type="button" value=" " class="previous" disabled onClick="ItemLoader.previous('<?php echo $category ?>', getNavigationPattern(this))">
	<div class="currentPage">Pagina 1</div>
	<input type="button" value=" " class="next" disabled onClick="ItemLoader.next('<?php echo $category ?>', getNavigationPattern(this))">
</nav>
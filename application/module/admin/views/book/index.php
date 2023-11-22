<?php include_once(MODULE_PATH . 'admin/views/toolbar.php'); ?>
<?php include_once('submenu/index.php');

$columnPost		= $this->arrParams['filter_column'] ?? '';
$orderPost		= $this->arrParams['filter_column_dir'] ?? '';
$lblName 		= Helper::cmsLinkSort('Name', 'name', $columnPost, $orderPost);
$lblPicture		= Helper::cmsLinkSort('Picture', 'picture', $columnPost, $orderPost);
$lblPrice 		= Helper::cmsLinkSort('Price', 'price', $columnPost, $orderPost);
$lblSaleOff		= Helper::cmsLinkSort('Sale Off', 'sale_off', $columnPost, $orderPost);
$lblStatus		= Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
$lblSpecial		= Helper::cmsLinkSort('Special', 'special', $columnPost, $orderPost);
$lblCategory	= Helper::cmsLinkSort('Category', 'category_id', $columnPost, $orderPost);
$lblOrdering	= Helper::cmsLinkSort('Ordering', 'ordering', $columnPost, $orderPost);
$lblCreated		= Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);
$lblCreatedBy	= Helper::cmsLinkSort('Created By', 'created_by', $columnPost, $orderPost);
$lblModified	= Helper::cmsLinkSort('Modified', 'modified', $columnPost, $orderPost);
$lblModifiedBy	= Helper::cmsLinkSort('Modified By', 'modified_by', $columnPost, $orderPost);
$lblID			= Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);

$arrStatus = ['default' => '- Select Status -', 1 => 'Publish', 0 => 'UnPublish'];
$selectboxStatus = Helper::cmsSelecbox('filter_state', 'inputbox', $arrStatus, $this->arrParams['filter_state'] ?? '');

$arrSpecial = ['default' => '- Select Special -', 1 => 'Yes', 0 => 'No'];
$selectboxSpecial = Helper::cmsSelecbox('filter_special', 'inputbox', $arrSpecial, $this->arrParams['filter_special'] ?? '');


$selectboxCategory = Helper::cmsSelecbox('filter_category_id', 'inputbox', $this->slbCategory, $this->arrParams['filter_category_id'] ?? '');

// Pagination
$paginationHTML		= $this->pagination->showPagination(URL::createLink('admin', 'book', 'index'));

$messenger = Session::get('message');
Session::delete('message');
$strMessage = Helper::cmsMessage($messenger);


?>


<div id="system-message-container"><?= $strMessage ?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm">
			<!-- FILTER -->
			<fieldset id="filter-bar">
				<div class="filter-search fltlft">
					<label class="filter-search-lbl" for="filter_search">Filter:</label>
					<input type="text" name="filter_search" id="filter_search" value="<?= $this->arrParams['filter_search'] ?? '' ?>">
					<button type="submit" name="submit_keyword">Search</button>
					<button type="button" name="clear_keyword">Clear</button>
				</div>
				<div class="filter-select fltrt">
					<?= $selectboxSpecial . $selectboxStatus .$selectboxCategory ?>
				</div>
			</fieldset>
			<div class="clr"> </div>
			<table class="adminlist" id="modules-mgr">
				<!-- HEADER TABLE -->
				<thead>
					<tr>
						<th width="1%">
							<input type="checkbox" name="checkall-toggle">
						</th>
						<th class="title"><?= $lblName; ?></th>
						<th width="8%"><?php echo $lblPicture; ?></th>
						<th width="6%"><?php echo $lblPrice; ?></th>
						<th width="6%"><?php echo $lblSaleOff; ?></th>
						<th width="10%"><?php echo $lblCategory;?></th>
						<th width="5%"><?php echo $lblStatus; ?></th>
						<th width="5%"><?php echo $lblSpecial; ?></th>
						<th width="6%"><?php echo $lblOrdering; ?></th>
						<th width="7%"><?php echo $lblCreated; ?></th>
						<th width="7%"><?php echo $lblCreatedBy; ?></th>
						<th width="7%"><?php echo $lblModified; ?></th>
						<th width="7%"><?php echo $lblModifiedBy; ?></th>
						<th width="1%" class="nowrap"><?= $lblID; ?></th>
					</tr>
				</thead>
				<!-- FOOTER TABLE -->
				<tfoot>
					<tr>
						<td colspan="10">
							<!-- PAGINATION -->
							<div class="container">
								<div class="pagination">
									<?= $paginationHTML ?>
								</div>
							</div>
						</td>
					</tr>
				</tfoot>
				<!-- BODY TABLE -->
				<tbody>
					<?php if (!empty($this->Item)) {
						$i = 0;
						foreach ($this->Item as $key => $value) {
							$id = $value['id'];
							$ckb = '<input type="checkbox" name="cid[]" value="' . $id . '"">';
							$name = $value['name'];
							$price = $value['price'];
							$sale_off = $value['sale_off'];
							$picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $value['picture'];
							if (file_exists($picturePath) == true) {
								$picture	= '<img width="60" height="90" src="' . UPLOAD_URL . 'book' . DS . '98x150-' . $value['picture'] . '">';
							} else {
								$picture	= '<img src="' . UPLOAD_URL . 'category' . DS . '60x90-default.jpg' . '">';
							}
							$status = Helper::formatStatus($value['status'], URL::createLink('admin', 'book', 'changeStatus', ['id' => $id, 'status' => $value['status']]), $id);
							$special = Helper::formatSpecial($value['special'], URL::createLink('admin', 'book', 'changeSpecial', ['id' => $id, 'special' => $value['special']]), $id);
							$order = '<input type="text" name="order[' . $value['id'] . ']" size="5" value="' . $value['ordering'] . '" class="text-area-order">';
							$created = Helper::formatDate('d-m-Y', $value['created']);
							$categoryName	= $value['name_category'];
							$created_by = $value['created_by'];
							$modified = Helper::formatDate('d-m-Y', $value['modified']);;
							$modified_by = $value['modified_by'];
							$row = ($i % 2 == 0) ? 'row0' : 'row1';
							$linkEdit	= URL::createLink('admin', 'book', 'form', array('id' => $id));

					?>
							<tr class="<?= $row ?>">
								<td class="center"><?= $ckb ?></td>
								<td class="center"><a href="<?= $linkEdit ?>"><?= $name ?></a></td>
								<td class="center"><?= $picture ?></td>
								<td class="center"><?= number_format($price) ?></td>
								<td class="center"><?= $sale_off ?></td>
								<td class="center"><?= $categoryName ?></td>
								<td class="center"><?= $status ?></td>
								<td class="center"><?= $special ?></td>
								<td class="center"><?= $order ?></td>
								<td class="center"><?= $created ?></td>
								<td class="center"><?= $created_by ?></td>
								<td class="center"><?= $modified ?></td>
								<td class="center"><?= $modified_by ?></td>
								<td class="center"><?= $id ?></td>
							</tr>
					<?php
							$i++;
						}
					}
					?>
				</tbody>
			</table>

			<div>
				<input type="hidden" name="filter_column" value="name">
				<input type="hidden" name="filter_page" value="1">
				<input type="hidden" name="filter_column_dir" value="asc">
			</div>
		</form>

		<div class="clr"></div>
	</div>
</div>
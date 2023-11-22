<?php include_once (MODULE_PATH . 'admin/views/toolbar.php'); ?>
<?php include_once('submenu/index.php');
$columnPost		= $this->arrParams['filter_column'] ?? '';
$orderPost		= $this->arrParams['filter_column_dir'] ?? '';
$lblName 		= Helper::cmsLinkSort('Name', 'username', $columnPost, $orderPost);
$lblStatus		= Helper::cmsLinkSort('Status', 'status', $columnPost, $orderPost);
$lblEmail		= Helper::cmsLinkSort('Email', 'email', $columnPost, $orderPost);
$lblFullName	= Helper::cmsLinkSort('Full Name', 'fullname', $columnPost, $orderPost);
$lblGroup		= Helper::cmsLinkSort('Group Name', 'group_id', $columnPost, $orderPost);
$lblOrdering	= Helper::cmsLinkSort('Ordering', 'ordering', $columnPost, $orderPost);
$lblCreated		= Helper::cmsLinkSort('Created', 'created', $columnPost, $orderPost);
$lblCreatedBy	= Helper::cmsLinkSort('Created By', 'created_by', $columnPost, $orderPost);
$lblModified	= Helper::cmsLinkSort('Modified', 'modified', $columnPost, $orderPost);
$lblModifiedBy	= Helper::cmsLinkSort('Modified By', 'modified_by', $columnPost, $orderPost);
$lblID			= Helper::cmsLinkSort('ID', 'id', $columnPost, $orderPost);

$arrStatus = ['default' => '- Select Status -', 1 => 'Publish', 0 => 'UnPublish'];
$selectboxStatus = Helper::cmsSelecbox('filter_state','inputbox',$arrStatus, $this->arrParams['filter_state'] ?? '');


$selectboxGroup = Helper::cmsSelecbox('filter_group_id','inputbox',$this->slbGroup, $this->arrParams['filter_group_id'] ?? '');

// Pagination
$paginationHTML		= $this->pagination->showPagination(URL::createLink('admin', 'user', 'index'));

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
					<?= $selectboxStatus . $selectboxGroup ?>
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
						<th class="title"><?= $lblFullName; ?></th>
						<th class="title"><?= $lblEmail; ?></th>
						<th width="10%"><?= $lblStatus; ?></th>
						<th width="10%"><?= $lblGroup; ?></th>
						<th width="10%"><?= $lblOrdering; ?></th>
						<th width="10%"><?= $lblCreated; ?></th>
						<th width="10%"><?= $lblCreatedBy; ?></th>
						<th width="10%"><?= $lblModified; ?></th>
						<th width="10%"><?= $lblModifiedBy; ?></th>
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
							$name = $value['username'];
							$fullname = $value['fullname'];
							$email = $value['email'];
							$status = Helper::formatStatus($value['status'], URL::createLink('admin', 'user', 'changeStatus', ['id' => $id, 'status' => $value['status']]), $id);
							$groupName = $value['group_name'];
							$order = '<input type="text" name="order['.$value['id'].']" size="5" value="' . $value['ordering'] . '" class="text-area-order">';
							$created = Helper::formatDate('d-m-Y', $value['created']);
							$created_by = $value['created_by'];
							$modified = Helper::formatDate('d-m-Y', $value['modified']);;
							$modified_by = $value['modified_by'];
							$row = ($i % 2 == 0) ? 'row0' : 'row1';
							$linkEdit	= URL::createLink('admin', 'user', 'form', array('id' => $id));

					?>
							<tr class="<?= $row ?>">
								<td class="center"><?= $ckb ?></td>
								<td class="center"><a href="<?= $linkEdit ?>"><?= $name ?></a></td>
								<td class="center"><?= $fullname ?></td>
								<td class="center"><?= $email ?></td>
								<td class="center"><?= $status ?></td>
								<td class="center"><?= $groupName ?></td>
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
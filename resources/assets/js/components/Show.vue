<template>
<div class="modal fade" id="viewRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">View Record</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<thead>
						<tr class="text-center">
							<th>ID</th>
							<th>Name</th>
							<th>E-Mail</th>
							<th>Phone</th>
						</tr>
					</thead>
					<tbody>
						<tr class="text-center">
							<th v-text="viewRec.id"></th>
							<td v-text="viewRec.name"></td>
							<td v-text="viewRec.email"></td>
							<td v-text="viewRec.phone"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
	export default {
		props: ['viewRec']
	};
</script>
<template>
<div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
				<button type="button" class="close" @click="clearModal" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="alert alert-success" v-if="success.length > 0" v-text="success"></p>

				<div class="form-group">
					<label for="name">Name</label>

					<input type="text" 
						   name="name" 
						   id="name" 
						   class="form-control" 
						   v-model="record.name"
						   @keydown="delete errors.name">

					<span v-if="errors.name" class="text-danger">
						<small v-text="errors.name[0]"></small>
					</span>
				</div>

				<div class="form-group">
					<label for="email">E-Mail</label>

					<input type="email" 
						   name="email" 
						   id="email" 
						   class="form-control" 
						   v-model="record.email" 
						   @keydown="delete errors.email">

					<span v-if="errors.email" class="text-danger">
						<small v-text="errors.email[0]"></small>
					</span>
				</div>

				<div class="form-group">
					<label for="phone">Phone</label>

					<input type="text" 
						   name="phone" 
						   id="phone" 
						   class="form-control" 
						   v-model="record.phone"
						   @keydown="delete errors.phone">

					<span v-if="errors.phone" class="text-danger">
						<small v-text="errors.phone[0]"></small>
					</span>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" 
						class="btn btn-outline-secondary" 
						@click="clearModal" 
						data-dismiss="modal">Close</button>

				<button type="submit" class="btn btn-outline-primary" @click="saveRecord">Save</button>
			</div>
		</div>
	</div>
</div>
</template>
<script>
	export default {
		data() {
			return {
				record: {},
				errors: [],
				success: ''
			}
		},
		methods: {
			saveRecord() {
				axios.post('/phonebooks', this.record)
					.then(data => {
						this.$emit('recordAdded', data);
						this.success = 'Record Added Successfully';
						this.record = {}
					})
					.catch(error => this.errors = error.response.data.errors)
			},

			clearModal() {
				this.success = '';
				this.errors = [];
			}
		}
	};
</script>
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
				<p class="alert alert-success" v-if="success.length > 0">{{ success }}</p>
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" class="form-control" v-model="name">
					<span v-if="errors.name" class="text-danger">
						<strong v-for="err of errors.name">{{ err }}</strong>
					</span>
				</div>
				<div class="form-group">
					<label for="email">E-Mail</label>
					<input type="email" name="email" id="email" class="form-control" v-model="email">
					<span v-if="errors.email" class="text-danger">
						<strong v-for="err of errors.email">{{ err }}</strong>
					</span>
				</div>
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" name="phone" id="phone" class="form-control" v-model="phone">
					<span v-if="errors.phone" class="text-danger">
						<strong v-for="err of errors.phone">{{ err }}</strong>
					</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" @click="clearModal" data-dismiss="modal">Close</button>
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
				name: '',
				email: '',
				phone: '',
				errors: [],
				success: ''
			}
		},
		methods: {
			saveRecord() {
				axios.post('/records', {
					'name': this.name,
					'email': this.email,
					'phone': this.phone,
				})
					.then(data => {
						this.$emit('recordAdded', data);
						this.success = 'Record Added Successfully';
						this.name = '';
						this.email = '';
						this.phone = '';
					})
					.catch(error => this.errors = error.response.data.errors)
			},
			clearModal() {
				this.success = '';
				this.errors = [];
			}
		}
	}
</script>
<template>
    <div>
        <div class="row">
            <div class="col-8">
                <h2 class="text-center">Status List</h2>
                <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="stat in all_status" :key="stat.id">
                <td>{{ stat.id }}</td>
                <td>{{ stat.name }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" @click="editStatus(stat.id)">Edit</button>
                        <!-- <router-link :to="{name: 'edit', params: { id: stat.id }}" class="btn btn-success">Edit</router-link> -->
                        <button class="btn btn-danger" @click="deleteStatus(stat.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
            </div>
            <div class="col-4">
                <h2 class="text-center">Add Status</h2>
                <form @submit.prevent="addStatus">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="status.name">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </form>
            </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Status</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form @submit.prevent="updateStatus">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="edit_status.name">
                        <input type="hidden" class="form-control" v-model="edit_status.id">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal" ref="closeBtn">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    </div>
</template>

<script>
    export default {
        name:"status",
        data() {
            return {
                user:this.$store.state.auth.user,
                status: {},
                all_status:[],
                edit_status:{},
            }
        },
        created() {
            this.getStatus();
        },
        methods: {
            deleteStatus(id) {
                axios
                    .delete(`/api/v1/status/${id}`);
                    this.getStatus();
            },
            editStatus(id){
                axios
                .get(`/api/v1/status/${id}`)
                .then(response => {
                    this.edit_status = response.data.data;
                });
            },
            addStatus() {
                axios
                    .post('/api/v1/status', this.status)
                    .then(response => (
                        this.$router.push({ name: 'status' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
                    this.getStatus();
            },
            updateStatus() {
                this.closeModal();
                axios
                    .patch(`/api/v1/status/${this.edit_status.id}`, this.edit_status)
                    .then(response => (
                        this.$router.push({ name: 'status' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
                    this.getStatus();
            },
            getStatus(){
                axios
                .get('/api/v1/status/')
                .then(response => {
                    this.all_status = response.data.data;
                });
            },
            closeModal($event) {
                const elem = this.$refs.closeBtn
                elem.click()
            }
        }
    }
</script>

<template>
    <div>
        <div class="row">
            <div class="col-9">
                <h2 class="text-center">Tasks List</h2>
                <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Start Date</th>
                <th>end Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in all_tasks" :key="task.id">
                <td>{{ task.id }}</td>
                <td>{{ task.name }}</td>
                <td>{{ task.status.name }}</td>
                <td>{{ task.due_date }}</td>
                <td v-if="task.users">{{ task.users.start_time }}</td>
                <td v-else> - </td>
                <td v-if="task.users">{{ task.users.end_time }}</td>
                <td v-else> - </td>
                <td>
                    <div class="btn-group" role="group">
                        <button v-if="!task.users" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal" @click="editTask(task.id)">Assign User</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" @click="editTask(task.id)">Edit</button>
                        <button class="btn btn-danger" @click="deleteTask(task.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
            </div>
            <div class="col-3">
                <h2 class="text-center">Add Task</h2>
                <form @submit.prevent="addTask">
                    <!-- <p v-if="errors.length">
                        <b>Please correct the following error(s):</b>
                        <ul>
                        <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </p> -->
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="task.name">
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" v-model="task.status" required>
                            <option value="">Choose Status</option>
                            <option v-for="status in all_status" :key="status.id" :value="status.id">{{status.name}}</option>
                                </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" v-model="task.due_date">
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
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Task</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form @submit.prevent="updateTask">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="edit_task.name">
                        <input type="hidden" class="form-control" v-model="edit_task.id">
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" v-model="edit_task.status" required>
                            <option value="">Choose Status</option>
                            <option
                            v-for="status in all_status"
                            :key="status.id"
                            :value="status.id"
                            :selected="status.id == edit_task.id"
                            >{{status.name}}</option>
                                </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" v-model="edit_task.due_date" required>
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

<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Assign Task</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form @submit.prevent="assignTask">
                    <div class="form-group">
                        <label>Task</label>
                        <input type="text" class="form-control" v-model="edit_task.name">
                        <input type="hidden" class="form-control" v-model="edit_task.id">
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <select id="status" class="form-control" v-model="edit_task.status" required>
                            <option value="">Choose Status</option>
                            <option
                            v-for="status in all_status"
                            :key="status.id"
                            :value="status.id"
                            :selected="status.id == edit_task.id"
                            >{{status.name}}</option>
                                </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" v-model="edit_task.due_date" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="start_time">Start Time</label>
                        <input type="date" class="form-control" v-model="edit_task.start_time" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="end_time">End Time</label>
                        <input type="date" class="form-control" v-model="edit_task.end_time" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" v-model="edit_task.remarks" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal" ref="closeBtn">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="assignedModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Assigned Task</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

                    <div class="form-group">
                        <label>Task</label>
                        <input type="text" class="form-control" v-model="edit_task.name">
                        <input type="hidden" class="form-control" v-model="edit_task.id">
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <input type="date" class="form-control" v-model="edit_task.name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" v-model="edit_task.due_date" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="start_time">Start Time</label>
                        <input type="date" class="form-control" v-model="edit_task.start_time" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="end_time">End Time</label>
                        <input type="date" class="form-control" v-model="edit_task.end_time" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" v-model="edit_task.remarks" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal" ref="closeBtn">Close</button>
      </div>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {
        name:"task",
        data() {
            return {
                user:this.$store.state.auth.user,
                task: {},
                all_tasks:[],
                all_status:[],
                edit_task:{},
                errors: [],
            }
        },
        created() {
            this.getTask();
            this.getStatus();
        },
        methods: {
            deleteTask(id) {
                axios
                    .delete(`/api/v1/task/${id}`);
                    this.getTask();
            },
            editTask(id){

                axios
                .get(`/api/v1/task/${id}`)
                .then(response => {
                    this.edit_task = response.data.data;
                    console.log(this.edit_task);
                });
            },
            addTask() {
                axios
                    .post('/api/v1/task/', this.task)
                    .then(response => (
                        this.$router.push({ name: 'task' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
                    this.getTask();
            },
            updateTask() {
                this.closeModal();
                axios
                    .patch(`/api/v1/task/${this.edit_task.id}`, this.edit_task)
                    .then(response => (
                        this.$router.push({ name: 'task' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
                    this.getTask();
            },
            getTask(){
                axios
                .get('/api/v1/task/')
                .then(response => {
                    this.all_tasks = response.data.data;
                });
            },
            getStatus(){
                axios
                .get('/api/v1/status/')
                .then(response => {
                    this.all_status = response.data.data;
                });
            },
            assignTask() {
                this.closeModal();
                this.edit_task['user'] = this.user.id;
                console.log(this.edit_task);
                axios
                    .post('/api/v1/task/assign', this.edit_task)
                    .then(response => (
                        this.$router.push({ name: 'task' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
                    this.getTask();
            },
            closeModal($event) {
                const elem = this.$refs.closeBtn
                elem.click()
            }
        }
    }
</script>

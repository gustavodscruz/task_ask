<script setup>
import Layout from '@/Shared/Layout.vue'
import NewQuestionModal from './NewQuestionModal.vue';
import { ref } from 'vue';
const showNewQuestionModal = ref(false);

function createQuestion() {
    showNewQuestionModal.value = true;
}

function destroyModal() {
    showNewQuestionModal.value = false;
}

</script>
<template>
    <Layout>
        <button @click="createQuestion" class="btn btn-success">Create</button>


        <Teleport to="body">
            <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
                <template #header>
                    <h3>Create Question</h3>
                </template>
                <template #body>
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Question</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Answers</th>
                                    <th scope="col">Correct ?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>

                                    <td><input type="text" class="form-control" id="answer" placeholder="Enter answer"></td>
                                    <td><input type="radio"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </template>
                <template #footer>
                    <button class="btn btn-primary">Save</button>
                </template>
            </NewQuestionModal>
        </Teleport>
    </Layout>
</template>
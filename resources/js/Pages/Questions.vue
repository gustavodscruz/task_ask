<script setup>
import Layout from '@/Shared/Layout.vue'
import NewQuestionModal from './NewQuestionModal.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/core';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
const page = usePage();
const success = computed(() => page.props.flash.success);
const showNewQuestionModal = ref(false);
const showViewQuestionModal = ref(false);
const createdQuestion = ref(null);
const newAnswers = ref([]);
const answers = ref(null);
const selectedQuestion = ref(null);
const selectedanswer = ref(null);

let answerId = 1;

function createQuestion() {
    showNewQuestionModal.value = true;
}

function destroyModal() {
    showNewQuestionModal.value = false;
    showViewQuestionModal.value = false;
}

function addNewAnswer() {
    const newAnswer = {
        id: answerId++,
        answer: '',
        correct_answer: 0
    }

    newAnswers.value.push(newAnswer)
}
function handleRadioToggle(Id) {
    selectedanswer.value = Id;
    newAnswers.value.forEach((answer) => {
        if (answer.id === Id) {
            answer.correct_answer = 1;
        } else {
            answer.correct_answer = 0;
        }
    })
}
function validateAnswers() {
    for (const answer of newAnswers.value) {
        if (answer.answer.trim() === '') {
            return false;
        }
    }
    return true;
}

function answerCount() {
    if (newAnswers.length < 4) {
        alert('Four answers are required');
    } else if (newAnswers.length === 4) {
        return true;
    }
    return false;
}
function submitQuestion() {
    if (!createdQuestion.value) {
        alert('Question cannot be empty');
        return false;
    }
    if (!validateAnswers() && !answerCount()) {
        alert('Fill all inputs before submitting');
        return false
    }
    router.post('/questions', {
        question: createdQuestion.value,
        answers: newAnswers.value
    })
    router.on('success', () => {
        createdQuestion.value = null;
        newAnswers.value = [];
    })
}

const props = defineProps({
    questions: Object,
    errors: Object
})

function viewQuestion(index) {
    showViewQuestionModal.value = true;
    selectedQuestion.value = props.questions[index];
    answers.value = props.questions[index].answers;
}

const selectedEditAnswer = ref(null);
function editAnswer(Id) {
    selectedEditAnswer.value = Id;
    answers.value.forEach((answer) => {
        if (answer.id === Id) {
            answer.correct_answer = 1;
        } else {
            answer.correct_answer = 0;
        }
    })
}

</script>
<template>
    <Layout>
        <button @click="createQuestion" class="btn btn-success">Create</button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col">Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(question, index) in questions">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ question.question }}</td>
                    <td>
                        <button @click="viewQuestion(index)" class="btn btn-primary">View</button>
                        <button class="btn btn-success">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                    <td>@mdo</td>
                </tr>
            </tbody>
        </table>

        <Teleport to="body">
            <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
                <template #header>
                    <h3>Create Question</h3>
                </template>
                <template #success>
                    <div v-if="success" class="alert alert-success">{{ success }}</div>
                </template>
                <template #body>
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Question</label>
                            <input type="text" v-model="createdQuestion" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
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
                                <tr v-for="(answer, index) in newAnswers">
                                    <th scope="row">{{ answer.id }}</th>
                                    <td><input type="text" v-model="answer.answer" class="form-control" id="answer"
                                            placeholder="Enter answer"></td>
                                    <td><input :checked="answer.correct_answer === 1" class="form-check-input"
                                            :value="answer.id" @change="handleRadioToggle(answer.id)" type="radio"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </template>
                <template #footer>
                    <span @click="addNewAnswer" v-if="newAnswers.length < 4">
                        <h3>+</h3>
                    </span>
                    <button @click="destroyModal" class="btn btn-danger">Close</button>
                    <button @click="submitQuestion" v-if="newAnswers.length > 3" class="btn btn-success">Submit</button>
                </template>
            </NewQuestionModal>
            <NewQuestionModal :show="showViewQuestionModal" @close="destroyModal">
                <template #header>
                    <h3>View Question/Answers</h3>
                </template>
                <template #body>
                    <p><strong>Q.{{ selectedQuestion.questions }}</strong></p>
                    <table class="table">
                    <tbody>
                        <tr v-for="(answer, index) in answers">
                            <th scope="row">{{ index+1 }}</th>
                            <td><input type="text" v-model="answer.answer" class="form-control" id="answer"
                                    placeholder="Enter answer"></td>
                            <td><input :checked="answer.correct_answer === 1" class="form-check-input" :value="answer.id"
                                    @change="handleRadioToggle(answer.id)" type="radio"></td>
                        </tr>
                    </tbody>
                    </table>
                </template>
                <template #footer>
                    <button @click="destroyModal" class="btn btn-danger">Close</button>
                    <button class="btn btn-success">Save</button>
                </template>
            </NewQuestionModal>

        </Teleport>
    </Layout>
</template>
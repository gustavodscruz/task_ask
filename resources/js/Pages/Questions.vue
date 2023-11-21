<script setup>
import Layout from '@/Shared/Layout.vue'
import NewQuestionModal from './NewQuestionModal.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/core';
const showNewQuestionModal = ref(false);
const createdQuestion=ref(null);
const newAnswers = ref([]);
const selectedanswer = ref(null);

let answerId = 1;

function createQuestion() {
    showNewQuestionModal.value = true;
}

function destroyModal() {
    showNewQuestionModal.value = false;
}

function addNewAnswer(){
    const newAnswer ={
        id: answerId++,
        answer: '',
        correct_answer: 0
    }

    newAnswers.value.push(newAnswer)
}
function handleRadioToggle(Id){
    selectedanswer.value = Id;
    newAnswers.value.forEach((answer)=>{
        if(answer.id === Id){
            answer.correct_answer = 1;
        }else{
            answer.correct_answer = 0;
        }
    })  
}
function validateAnswers(){
    for(const answer of newAnswers.value){
        if(answer.answer.trim() === ''){
            return false;
        }
    }
    return true;
}

function answerCount(){
    if(newAnswers.length<4){
        alert('Four answers are required');
    }else if(newAnswers.length === 4){
        return true;
    }
    return false;
}
function submitQuestion(){
    if(!createdQuestion.value){
        alert('Question cannot be empty');
        return false;
    }
    if(!validateAnswers() && !answerCount()){
        alert('Fill all inputs before submitting');
        return false
    }
    router.post('/questions', {
        question: createdQuestion.value,
        answers: newAnswers.value
    })
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
                            <input type="text" v-model="createdQuestion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
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
                                    <th scope="row">{{answer.id}}</th>
                                    <td><input type="text" v-model="answer.answer" class="form-control" id="answer" placeholder="Enter answer"></td>
                                    <td><input :checked="answer.correct_answer === 1" class="form-check-input" :value="answer.id" @change="handleRadioToggle(answer.id)" type="radio"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </template>
                <template #footer>
                    <span @click="addNewAnswer" v-if="newAnswers.length<4"><h3>+</h3></span>
                    <button @click="destroyModal" class="btn btn-danger">Close</button>
                    <button @click="submitQuestion" v-if="newAnswers.length>3" class="btn btn-success">Submit</button>
                </template>
            </NewQuestionModal>
        </Teleport>
    </Layout>
</template>
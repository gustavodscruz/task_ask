<script setup>
import Layout from '@/Shared/Layout.vue'
import { ref } from 'vue'
const props = defineProps({
    questions: Object
})

const currentIndex = ref(0)

const currentquestion = computed(() => {
    return props.questions[currentIndex.value]
})

const answers = computed(()=>{
    return props.questions[currentIndex.value].answers

})


</script>
<template>
    <Layout>
        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                        class="rounded-circle flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">{{currentQuestion.question}}</h6>
                            <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                        </div>
                        <small class="opacity-50 text-nowrap">now</small>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                        class="rounded-circle flex-shrink-0">
                    <div v-for="(answer, index) in answers" class="d-flex gap-2 w-100 justify-content-between">
                        <div >
                            <p class="mb-0 opacity-75">{{ answer.answer }}</p>
                        </div>
                        <small class="opacity-50 text-nowrap">3d</small>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32"
                        class="rounded-circle flex-shrink-0">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Third heading</h6>
                            <p class="mb-0 opacity-75">Some placeholder content in a paragraph.</p>
                        </div>
                        <small class="opacity-50 text-nowrap">1w</small>
                    </div>
                </a>
            </div>
    </div>
</Layout></template>
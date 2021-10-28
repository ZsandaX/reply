<template>
    <div id="surveyContainer">
        <survey :survey="survey"></survey>
    </div>
</template>

<script>
const surveyJSON = { surveyId: 'b2054b2f-6fab-4277-a3cd-6940b8da09a8', surveyPostId: '1e63b70f-ddfa-4584-beed-f63bdecaa800'}
//require("../survey/test.json");


export default {
    created() {
        console.log(this.survey);
    },
    data() {
        return {
            survey: new Survey.Model(surveyJSON),
        };
    },
    computed: {
        result(){
            return this.survey.getAllValues();
        }
    },
    watch: {

    },
    methods: {},
};
//
</script>

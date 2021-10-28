<template>
    <div>
        <el-card>
            <h1 class="text-primary">{{ paper.name }}</h1>
            <h3 class="text-secondary">{{ paper.description }}</h3>
            <slot></slot>
            <div v-for="group of paper.groups" :key="group.id">
                <Exam :paper="group">
                    <div v-for="question of group.questions" :key="question.id">
                        <h3>
                            {{ question.name }}
                        </h3>
                        <h5 class="text-secondary">
                            {{ question.description }}
                        </h5>
                        <ol>
                            <li
                                v-for="option of question.options"
                                :key="option.id"
                            >
                                {{ option.name }}
                            </li>
                        </ol>
                    </div>
                </Exam>
            </div>
        </el-card>
    </div>
</template>

<script>
export default {
    props: {
        paper: {
            type: Object
        }
    },
    created() {},
    data() {
        return {};
    },
    methods: {}
};
</script>

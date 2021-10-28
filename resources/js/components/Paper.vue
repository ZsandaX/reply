<template>
    <div>
        <Table name="papers" :value="value">
            <template v-slot:action="{row}">
                <el-dropdown-item
                    v-if="$route.meta.show"
                    icon="el-icon-view"
                    :command="{
                        args: row,
                        callback: show,
                    }"
                >
                    預覽
                </el-dropdown-item>
            </template>
        </Table>
        <Exam v-if="showed" :paper="paper"></Exam>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Array,
        },
    },
    data() {
        return {
            showing: null,
            showed: false,
            paper: {},
        };
    },
    methods: {
        show(item){
            this.showed = true;
            axios.get(`papers/${item.id}`).then((response) => {
                this.paper = response.data;
            });
        }
    },
};
</script>

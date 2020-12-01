<template>
    <el-form :model="item" :rules="rules" ref="ruleForm">
        <el-form-item label="顯示名稱" prop="label">
            <el-input v-model="item.label"></el-input>
        </el-form-item>
        <el-form-item label="儲存值" prop="value">
            <el-input-number v-model.number="item.value"></el-input-number>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')">送出</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
export default {
    props: ["model"],
    data() {
        return {
            item: {},
            rules: {
                label: [
                    {
                        type: "string",
                        required: true,
                        message: "請輸入標籤",
                        trigger: "blur"
                    }
                ],
                value: [
                    {
                        type: "number",
                        required: true,
                        message: "請輸入值",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    watch: {
        model:{
            handler(value){
                this.item = Object.assign({}, value);
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate(valid => {
                if (valid) {
                    this.$emit("submit", this.item);
                    this.item = {};
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    },
};
</script>

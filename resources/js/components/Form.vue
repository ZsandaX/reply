<template>
    <el-form :model="item" ref="ruleForm" v-loading="loading" :inline="inline">
        <el-form-item
            v-for="(field, prop) of fields"
            :key="prop"
            :label="field.label"
            :prop="prop"
            :error="(errors[prop] || [])[0]"
            :class="{ 'is-required': field.required }"
        >
            <component
                :is="field.component"
                v-model="item[prop]"
                :value.sync="item[prop]"
                :name="field.name || prop"
                v-bind="field"
                @blur="validate"
            >
                {{ field.text }}
            </component>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="submitForm">送出</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
import create from "../access/create";
import edit from "../access/edit";
import store from "../access/store";
import update from "../access/update";
import validate from "../access/validate";

export default {
    props: {
        inline: Boolean,
        model: {
            type: Object,
            default: function () {
                return {};
            },
        },
        name: String,
    },
    created() {
        this.item = Object.assign({}, this.model);
        if (this.model.id) {
            this.edit();
        } else {
            this.create();
        }
    },
    data() {
        return {
            item: {},
            fields: [],
            errors: {},
            loading: false,
        };
    },
    methods: {
        create() {
            this.loading = true;

            create(this.name)
                .then((response) => {
                    this.fields = response.data;
                })
                .then(() => {
                    this.loading = false;
                })
                .catch((error) => {});
        },
        edit() {
            this.loading = true;
            edit(this.name, this.item.id)
                .then((response) => {
                    this.fields = response.data;
                })
                .then(() => {
                    this.loading = false;
                })
                .catch((error) => {});
        },
        store() {
            store(this.name, this.item)
                .then((response) => {
                    this.errors = {};
                    this.$message.success("儲存成功");
                    this.$emit("refresh");
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.$message.error("儲存失敗");
                });
        },
        update() {
            update(this.name, this.item)
                .then((response) => {
                    this.errors = {};
                    this.$message.success("更新成功");
                    this.$emit("refresh");
                })
                .catch((errors) => {
                    this.errors = errors;
                    this.$message.error("更新失敗");
                });
        },
        validate() {
            validate(this.name, this.item)
                .then((response) => {
                    this.errors = {};
                })
                .catch((errors) => {
                    this.errors = errors;
                });
        },
        submitForm() {
            if (this.model.hasOwnProperty("id")) {
                this.update();
            } else {
                this.store();
            }
        },
        resetForm(formName) {
            this.item = {};
        },
    },
};
</script>

<template>
    <draggable
        class="dragArea"
        :style="{ backgroundColor }"
        tag="ul"
        :list="data"
        group="item"
        @change="change"
    >
        <li v-for="item in data" :key="item.id">
            <div class="d-inline-flex justify-content-between w-100 pt-2 pr-3">
                <div>
                    <i :class="item.icon"></i>
                    <span>{{ item.label }}</span>
                    <span>{{ item.path }}</span>
                </div>
                <el-dropdown trigger="click" @command="command">
                    <span class="el-dropdown-link">
                        <i class="el-icon-more text-secondary"></i>
                    </span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item
                            icon="el-icon-edit-outline"
                            :command="{ args: item, callback: edit }"
                        >
                            編輯
                        </el-dropdown-item>
                        <el-dropdown-item
                            icon="el-icon-delete"
                            :command="{ args: item, callback: destroy }"
                            >刪除</el-dropdown-item
                        >
                    </el-dropdown-menu>
                </el-dropdown>
            </div>
            <Node
                :parent-id="item.id"
                :level="level + 1"
                :data="item.children"
                @edit="edit"
                @update="update"
                @destroy="destroy"
            />
        </li>
    </draggable>
</template>

<script>
export default {
    props: ["parentId", "level", "data"],
    computed: {
        backgroundColor() {
            return `rgb(255,255,0,${this.level / 20})`;
        },
    },
    methods: {
        change(event) {
            if (event.added) {
                this.data.forEach((item, index) => {
                    if (item.order != index || item.menu_id != this.parentId) {
                        this.$emit("update", {
                            id: item.id,
                            order: index,
                            menu_id: this.parentId,
                        });
                    }
                });
            }
            if (event.removed || event.moved) {
                this.data.forEach((item, index) => {
                    if (item.order != index) {
                        this.$emit("update", { id: item.id, order: index });
                    }
                });
            }
        },
        command(command) {
            command.callback(command.args);
        },
        update(item) {
            this.$emit("update", item);
        },
        edit(item) {
            this.$emit("edit", item);
        },
        destroy(item) {
            this.$emit("destroy", item);
        },
    },
};
</script>
<style scoped>
.dragArea {
    margin: 8px;
    min-height: 30px;
    border: 1px dashed;
    border-radius: 5px;
}
</style>

<template>
    <div>
        <Table name="options" :value="value"></Table>
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
        };
    },
    methods: {

    },
};
</script>

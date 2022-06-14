<template>
    <ul>
        <li v-for="item in propItems">
            <div class="col-xs-12">
                <input v-if="Number(propOptions.except) !== item.id" :id="`cat_${item.id}`" :type="propOptions.multiple ? 'checkbox' : 'radio'" :value="item.id"
                       :checked="propOptions.selected.includes(item.id)"
                       :name="`${propOptions.field}${propOptions.multiple ? `[${item.id}]` : ''}`">
                <label class="col-form-label custom-label" :for="`cat_${item.id}`">{{item.name}}</label>
            </div>
            <category-tree v-if="item.sub_categories.length" :prop-items="item.sub_categories" :prop-options="propOptions"></category-tree>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'category-tree',
    props: {
        propItems: {
            type: Array,
        },
        propOptions: {
            type: Object,
        },
    }
}
</script>

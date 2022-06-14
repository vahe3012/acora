<template>
    <div>
        <div class="row mb-4">
            <div class="col-12 p-0 input-group-sm">
                <input
                    type="text"
                    v-model="search"
                    v-on:keyup="applyFilters()"
                    class="form-control"
                placeholder="Search...">
            </div>
        </div>
        <ul class="categories">
            <li v-if="!propMultiple">
                <input :id="`cat_0`" :type="'radio'" :value="0"
                       :name="propField"
                       :checked="propSelected.includes(0)">
                <label class="col-form-label" :for="`cat_0`">none</label>
            </li>
            <li v-for="category in categories">
                <input v-if="Number(propExcept) !== category.id" :id="`cat_${category.id}`" :type="propMultiple ? 'checkbox' : 'radio'" :value="category.id"
                       :name="`${propField}${propMultiple ? `[${category.id}]` : ''}`"
                       :checked="propSelected.includes(category.id)">
                <label class="col-form-label custom-label" :for="`cat_${category.id}`">{{category.name}}</label>
<!--                <category-tree-->
<!--                    v-if="category.sub_categories.length"-->
<!--                    :prop-items="category.sub_categories"-->
<!--                    :prop-options="{selected: propSelected, multiple: propMultiple, field: propField, except: propExcept}">-->
<!--                </category-tree>-->
            </li>
        </ul>
    </div>
</template>

<script>
// import CategoryTree from "./CategoryTree";
export default {
    name: 'category-select',
    // components: {CategoryTree},
    props: {
        propExcept: {
            type: Number,
        },
        propSelected: {
            type: Array,
        },
        propField: {
            type: String,
        },
        propMultiple: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            categories: [],
            search: ''
        }
    },
    methods: {
        async applyFilters(){
            const {data} = await axios.get(`/categories/list${this.search ? '?search=' + this.search : ''}`)

            this.categories = data.categories
        },
    },
    mounted() {
        this.applyFilters()
    }
}
</script>

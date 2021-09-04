<template>
    <nav v-if="isOnlyOnePage">
        <ul class="pagination justify-content-center mb-0">
            <li class="page-item">
                <button type="button" class="page-link" @click="onClickFirstPage" :disabled="isInFirstPage">
                    <i class="cil-arrow-left"></i>
                </button>
            </li>
            <li class="page-item">
                <button type="button" class="page-link" @click="onClickPreviousPage" :disabled="isInFirstPage">
                    prev
                </button>
            </li>
            <li class="page-item" v-if="currentPage > 3">
                <button type="button" @click="onClickPage(1)" class="page-link">
                    1
                </button>
            </li>
            <li class="page-item" v-if="currentPage > 4">
                <button type="button" class="page-link">...</button>
            </li>
            <li class="page-item" v-for="page in pages" :key="page.name">
                <button type="button" @click="onClickPage(page.name)" v-bind:class="[page.isDisabled ? 'active' : '', 'page-link']" :disabled="page.isDisabled">
                    {{ page.name }}
                </button>
            </li>
            <li class="page-item" v-if="currentPage < totalPages - 3">
                <button type="button" class="page-link">...</button>
            </li>
            <li class="page-item" v-if="currentPage < totalPages - 2">
                <button type="button" @click="onClickPage(totalPages)" class="page-link">
                    {{totalPages}}
                </button>
            </li>
            <li class="page-item">
                <button type="button" class="page-link" @click="onClickNextPage" :disabled="isInLastPage">
                    next
                </button>
            </li>
            <li class="page-item">
                <button type="button" class="page-link" @click="onClickLastPage" :disabled="isInLastPage">
                    <i class="cil-arrow-right"></i>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: {
            maxVisibleButtons: {
                type: Number,
                required: false,
                default: 3
            },
            totalPages: {
                type: Number,
                required: true
            },
            total: {
                type: Number,
                required: true
            },
            currentPage: {
                type: Number,
                required: true
            }
        },
        methods: {
                onClickFirstPage() {
                    this.$emit('pagechanged', 1);
                },
                onClickPreviousPage() {
                    this.$emit('pagechanged', this.currentPage - 1);
                },
                onClickPage(page) {
                    this.$emit('pagechanged', page);
                },
                onClickNextPage() {
                    this.$emit('pagechanged', this.currentPage + 1);
                },
                onClickLastPage() {
                    this.$emit('pagechanged', this.totalPages);
                }
        },
        computed: {
            
            isInFirstPage () {
                return this.currentPage === 1;
            },
            isInLastPage () {
                return this.currentPage === this.totalPages;
            },
            isOnlyOnePage () {
                return Number(this.totalPages) > 1
            },
            startPage () {
                if (this.currentPage === 1) {
                    return 1;
                }
            },
            pages () {
                const range = [];

                for (let i = 1; i <= this.totalPages; i++ ) {
                    if(i >=this.currentPage - 2 && i <= this.currentPage + 2) {
                        range.push({
                            name: i,
                            isDisabled: i === this.currentPage
                        });
                    }
                }
                return range;
            },
        }
    };
</script>
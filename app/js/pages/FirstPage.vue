<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">First page</div>

                    <div class="card-body">
                        This is a first page
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang='ts'>
import Vue from 'vue'
import { Component } from 'vue-property-decorator'

@Component
export default class FirstPage extends Vue {
}
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Test of axios instance</div>

                    <div class="card-body">
                        pops
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
    result = ''
    async mounted () {
        try {
            const result = await this.$axios.post('/api/langue.php', { lang: 'fr', ecran: 'pays' })
            console.log('test')
            console.log(result)
        } catch (err) {
            console.log('erreur')
            console.log(err)
        }
    }
}
</script>

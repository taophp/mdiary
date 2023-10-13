<template>
    <div id="serverStatus">
        <span v-if="isConnected" title="Server available" @click="testConnection">✅</span>
        <span v-else title="Server unavailable" @click="testConnection">❌</span>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            isConnected: false,
        };
    },
    methods: {
        async testConnection() {
            const serverConfig = JSON.parse(localStorage.getItem('serverConfig'));

            if (!serverConfig) {
                console.error('Configuration not found.');
                return;
            }

            try {
                const response = await fetch(serverConfig.url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                this.isConnected = response.ok;
            } catch (error) {
                console.error('Error testing connection:', error);
                this.isConnected = false;
            }
        }

    },
};
</script>
  
<style scoped>
div#serverStatus {
    float: left;
    margin: 2px .5em 0 0;
}
</style>
  
<template>
    <div>
        <span v-if="isConnected" title="SSH server available" @click="testSshConnection">✅</span>
        <span v-else title="SSH server unavailable" @click="testSshConnection">❌</span>
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
        async testSshConnection() {
            const sshConfig = JSON.parse(localStorage.getItem('sshConfig'));

            if (!sshConfig) {
                console.error('SSH configuration not found.');
                return;
            }

            const { sshHost, sshUser, sshKey } = sshConfig;
            const { Client } = require('ssh2');

            const conn = new Client();
            conn.on('ready', () => {
                console.log('Client :: ready');
                conn.exec('uptime', (err, stream) => {
                    if (err) throw err;
                    stream.on('close', (code, signal) => {
                        console.log('Stream :: close :: code: ' + code + ', signal: ' + signal);
                        conn.end();
                    }).on('data', (data) => {
                        console.log('STDOUT: ' + data);
                    }).stderr.on('data', (data) => {
                        console.log('STDERR: ' + data);
                    });
                });
            }).connect({
                host: '192.168.100.100',
                port: 22,
                username: 'frylock',
                password: ''
            });

        },
    },
};
</script>
  
<style scoped>
div {
    float: left;
    margin: 2px .5em 0 0;
}
</style>
  
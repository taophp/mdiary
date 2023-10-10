<template>
  <div>
    <markdown-editor></markdown-editor>
    <ssh-status ref="sshStatus" @ssh-connection-tested="onSshConnectionTested" /><button
      @click="toggleSSHConfigModal">⚙️</button>
    <ssh-config-modal v-if="isSSHConfigModalVisible" @close="hideSSHConfigModal" />
  </div>
</template>

<script>
import MarkdownEditor from '@/components/MarkdownEditor.vue';
import SshConfigModal from '@/components/SshConfigModal.vue';
import SshStatus from '@/components/SshStatus.vue';

export default {
  components: {
    MarkdownEditor,
    SshConfigModal,
    SshStatus,
  },
  data() {
    return {
      isSSHConfigModalVisible: false,
    };
  },
  methods: {
    toggleSSHConfigModal() {
      this.isSSHConfigModalVisible = !this.isSSHConfigModalVisible;
    },
    hideSSHConfigModal() {
      this.isSSHConfigModalVisible = false;
    },
    testSshConnection(sshConfig) {
      this.$refs.sshStatus.testSshConnection(sshConfig);
    },
    onSshConnectionTested(isConnected) {
      console.log('SSH connection test result:', isConnected);
    },
  },
  created() {
    this.$nextTick(() => {
      const sshConfig = JSON.parse(localStorage.getItem('sshConfig'));
      if (sshConfig) {
        this.testSshConnection(sshConfig);
      }
    });
  },
};
</script>

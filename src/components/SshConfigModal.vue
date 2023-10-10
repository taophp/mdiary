<template>
  <div class="modal">
    <div class="modal-content">
      <h2>Configuration SSH</h2>
      <form @submit.prevent="saveConfig">
        <label for="sshHost">🖥️</label>
        <input type="text" id="sshHost" v-model="sshHost" required><br>
        <label for="sshUser">👤</label>
        <input type="text" id="sshUser" v-model="sshUser" required><br>
        <label for="sshKey">🔑</label>
        <input type="text" id="sshKey" v-model="sshKey" required><br>
        <label for="sshDestination">📂</label>
        <input type="text" id="sshDestination" v-model="sshDestination" required><br>
        <button type="submit">💾</button>
      </form>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      sshHost: '',
      sshUser: '',
      sshKey: '',
      sshDestination: '',
    };
  },
  created() {
    const savedSSHConfig = JSON.parse(localStorage.getItem('sshConfig'));
    if (savedSSHConfig) {
      this.sshHost = savedSSHConfig.sshHost;
      this.sshUser = savedSSHConfig.sshUser;
      this.sshKey = savedSSHConfig.sshKey;
      this.sshDestination = savedSSHConfig.sshDestination;
    }
  },
  methods: {
    saveConfig() {
      const sshConfig = {
        sshHost: this.sshHost,
        sshUser: this.sshUser,
        sshKey: this.sshKey,
        sshDestination: this.sshDestination,
      };
      localStorage.setItem('sshConfig', JSON.stringify(sshConfig));
      this.$emit('close');
    },

  },
};
</script>

<style scoped>
label {
  display: inline-block;
  padding-right: .5em;
  margin: .5em 0;
}
</style>
<template>
  <div>
    <vue-easymde ref="easymde" v-model="fileOfTheDayContent" :configs="editorConfigs" @keydown="handleLineBreaks"></vue-easymde>
    <server-status ref="ServerStatus" /><button @click="toggleServerConfigModal">⚙️</button>
    <server-config-modal v-if="isServerConfigModalVisible" @close="hideServerConfigModal" />
  </div>
</template>

<script>
const AUTO_SAVE_INTERVAL = 500;
const INACTIVITY_THRESHOLD = 30000;

import VueEasymde from 'vue-easymde';
import ServerConfigModal from '@/components/ServerConfigModal.vue';
import ServerStatus from '@/components/ServerStatus.vue';
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';
import '@fortawesome/fontawesome-free/css/all.css';


export default {
  components: {
    VueEasymde,
    ServerConfigModal,
    ServerStatus,
  },
  data() {
    return {
      isServerConfigModalVisible: false,
      fileOfTheDayContent: '',
      lastSavedContent: '',
      lastKeyPressed: null,
      editorConfigs: {
        autofocus: true,
        spellChecker: false,
        status: false,
        autoDownloadFontAwesome: false,
      },
    };
  },
  methods: {
    toggleServerConfigModal() {
      this.isServerConfigModalVisible = !this.isServerConfigModalVisible;
    },
    hideServerConfigModal() {
      this.isServerConfigModalVisible = false;
    },
    testConnection(serverConfig) {
      this.$refs.ServerStatus.testConnection(serverConfig);
    },
    async loadFileOfTheDay() {
      const serverConfig = JSON.parse(localStorage.getItem('serverConfig'));
      const currentDate = new Date().toISOString().split('T')[0];
      const apiUrl = `${serverConfig.url}/${currentDate}.md`;
      try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
          throw new Error('Failed to load file of the day');
        }
        const data = await response.json();
        this.fileOfTheDayContent = data.content || this.initializeFileOfTheDayContent();
        this.lastSavedContent = this.fileOfTheDayContent;
      } catch (error) {
        console.error('Error loading file of the day:', error);
      }
    },
    saveContentToServer() {
      const serverConfig = JSON.parse(localStorage.getItem('serverConfig'));
      const currentDate = new Date().toISOString().split('T')[0];
      const apiUrl = `${serverConfig.url}/${currentDate}.md`;
      const content = this.fileOfTheDayContent;
      if (content !== this.lastSavedContent) {
        const bodyData = {
          content: content,
          type: "file"
        };
        fetch(apiUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(bodyData),
        })
          .then(response => {
            if (response.ok) {
              this.lastSavedContent = content;
            } else {
              throw new Error('Failed to save content to server');
            }
          })
          .catch(error => {
            console.error('Error saving content to server:', error);
          });
      }
    },

    startAutoSaveTimer() {
      setInterval(() => {
        this.saveContentToServer();
      }, AUTO_SAVE_INTERVAL);
    },

    setupEventListeners() {
      let inactivityTimeout = setTimeout(() => {
        this.saveContentToServer();
      }, INACTIVITY_THRESHOLD);

      document.addEventListener('mousemove', () => {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(() => {
          this.saveContentToServer();
        }, INACTIVITY_THRESHOLD);
      });

    },
    initializeFileOfTheDayContent() {
      const currentDate = format(new Date(), "dd MMMM yyyy", { locale: fr });

      return `---
layout: post
title: "Journal de bord"
date: ${currentDate}
description: ""
---\n`;
    },
    handleLineBreaks(event) {
      const cursorPosition = this.$refs.easymde.easymde.codemirror.getCursor();

      if (event.key === 'Enter') {
        if (this.lastKeyPressed === 'Enter') {
          const currentTime = new Date().toLocaleTimeString()+': ';
          console.log(cursorPosition);
          this.$refs.easymde.easymde.codemirror.replaceSelection(currentTime);
        }
      }

      this.lastKeyPressed = event.key;
    },

  },
  mounted() {
    const serverConfig = JSON.parse(localStorage.getItem('serverConfig'));
    this.$nextTick(() => {
      if (serverConfig) {
        this.$refs.ServerStatus.testConnection(serverConfig)
          .then(() => {
            if (this.$refs.ServerStatus.isConnected) {
              this.loadFileOfTheDay();
              this.startAutoSaveTimer();
              this.setupEventListeners();
            } else {
              console.error('not connected');
            }
          })
          .catch((error) => {
            console.error('Error testing connection:', error);
          });
      }
    });
  },
}
</script>

<style>
@import '~easymde/dist/easymde.min.css';
</style>

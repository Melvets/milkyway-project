<script type="module">
    import Chatbot from "https://cdn.jsdelivr.net/npm/flowise-embed/dist/web.js"
    Chatbot.init({
        chatflowid: "a00e12dc-0a36-4168-9515-df5bcc2fa7ae",
        apiHost: "https://cloud.flowiseai.com",
        chatflowConfig: {
            /* Chatflow Config */
        },
        observersConfig: {
            /* Observers Config */
        },
        theme: {
            button: {
                backgroundColor: '#73D2E6',
                right: 30,
                bottom: 30,
                size: 60,
                dragAndDrop: true,
                iconColor: 'white',
                customIconSrc: 'img/icon1.png',
                padding: 0,
                autoWindowOpen: {
                    autoOpen: false,
                    openDelay: 2,
                    autoOpenOnMobile: false
                }
            },
            tooltip: {
                showTooltip: true,
                tooltipMessage: 'Tanya-tanya sama MilkyBot yuk!👋',
                tooltipBackgroundColor: 'black',
                tooltipTextColor: 'white',
                tooltipFontSize: 12
            },
            disclaimer: {
                title: 'Disclaimer',
                message: "By using this chatbot, you agree to the <a target=\"_blank\" href=\"https://flowiseai.com/terms\">Terms & Condition</a>",
                textColor: 'black',
                buttonColor: '#3b82f6',
                buttonText: 'Start Chatting',
                buttonTextColor: 'white',
                blurredBackgroundColor: 'rgba(0, 0, 0, 0.4)',
                backgroundColor: 'white'
            },
            customCSS: `
                button[part="button"] {
                    box-shadow: none !important;
                    -webkit-box-shadow: none !important;
                    filter: none !important;
                    padding: 0 !important;
                    background: transparent !important;
                    overflow: visible !important;
                    border-radius: 0 !important;
                }
                
                button[part="button"] img {
                    width: 100px !important;
                    height: 100px !important;
                    object-fit: contain !important;
                    border-radius: 0 !important;
                }
            `,
            chatWindow: {
                showTitle: true,
                showAgentMessages: true,
                title: 'MilkyBot',
                titleAvatarSrc: 'img/icon1.png',
                welcomeMessage: 'Halo, selamat datang di Milkyway, silahkan ada yang bisa dibantu? 🥰',
                errorMessage: 'Maaf, MilkyBot jawab lain kali ya!',
                backgroundColor: '#fafafa',
                backgroundImage: 'enter image path or link',
                height: 500,
                width: 400,
                fontSize: 14,
                starterPrompts: [
                    "Mau tau menu dan harganya dong!🫣",
                    "Manfaatnya apa ya?🤔",
                    "Bedanya sama susu sapi apa tuh?",
                    "Aku mau pesen sekarang!😋",
                ],
                starterPromptFontSize: 12,
                clearChatOnReload: true,
                sourceDocsTitle: 'Sources:',
                renderHTML: true,
                botMessage: {
                    backgroundColor: '#e0f7fb',
                    textColor: '#303235',
                    showAvatar: true,
                    avatarSrc: 'img/icon2.png'
                },
                userMessage: {
                    backgroundColor: '#C8F3FA',
                    textColor: '#303235',
                    showAvatar: true,
                    avatarSrc: 'img/milkybot_user_avatar.png'
                },
                textInput: {
                    placeholder: 'Ketik disini ...',
                    backgroundColor: '#ffffff',
                    textColor: '#303235',
                    sendButtonColor: '#3B81F6',
                    maxChars: 50,
                    maxCharsWarningMessage: 'Tidak boleh lebih dari 50 karakter!',
                    autoFocus: true,
                    sendMessageSound: true,
                    sendSoundLocation: 'send_message.mp3',
                    receiveMessageSound: true,
                    receiveSoundLocation: 'receive_message.mp3'
                },
                feedback: {
                    color: '#303235'
                },
                dateTimeToggle: {
                    date: true,
                    time: true
                },
                footer: {
                    textColor: 'none',
                    text: '',
                    company: 'Milkyway - Susu Kambing',
                    companyLink: ''
                }
            }
        }
    })
</script>
<script>
  document.addEventListener('click', function(e) {
    const chatbot = document.querySelector('flowise-chatbot');
    if (chatbot && !chatbot.contains(e.target)) {
      // Cari shadow root lalu klik button close
      const shadow = chatbot.shadowRoot;
      if (shadow) {
        const closeBtn = shadow.querySelector('button[title="Close Chat"]');
        if (closeBtn) {
          closeBtn.click();
        }
      }
    }
  });
</script>
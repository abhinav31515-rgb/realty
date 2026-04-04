<template>
  <div class="fixed bottom-12 right-12 z-[100] w-96 bg-white shadow-2xl border border-charcoal/5 flex flex-col h-[500px]">
    <header class="bg-charcoal text-white p-6 flex justify-between items-center">
      <h4 class="text-xs uppercase tracking-widest font-bold">Concierge Chat</h4>
      <button @click="$emit('close')" class="material-symbols-outlined text-sm">close</button>
    </header>
    
    <div class="flex-1 overflow-y-auto p-6 space-y-4" ref="messageBox">
      <div v-for="msg in messages" :key="msg.id" :class="['max-w-[80%] p-4 text-sm', msg.sender_id == currentUserId ? 'ml-auto bg-gold text-white' : 'bg-charcoal/5 text-charcoal']">
        {{ msg.content }}
      </div>
    </div>

    <div class="p-6 border-t border-charcoal/5">
      <form @submit.prevent="sendMessage" class="flex space-x-4">
        <input v-model="newMessage" type="text" placeholder="Type your message..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm">
        <button type="submit" class="text-gold material-symbols-outlined">send</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { supabase } from '../../supabase';

const props = defineProps({ receiverId: Number, currentUserId: Number });
const messages = ref([]);
const newMessage = ref('');
const messageBox = ref(null);

const fetchMessages = async () => {
  const { data } = await supabase
    .from('messages')
    .select('*')
    .or(`and(sender_id.eq.${props.currentUserId},receiver_id.eq.${props.receiverId}),and(sender_id.eq.${props.receiverId},receiver_id.eq.${props.currentUserId})`)
    .order('created_at', { ascending: true });
  messages.value = data || [];
  scrollToBottom();
};

const sendMessage = async () => {
  if (!newMessage.value.trim()) return;
  await supabase.from('messages').insert({
    sender_id: props.currentUserId,
    receiver_id: props.receiverId,
    content: newMessage.value
  });
  newMessage.value = '';
};

const scrollToBottom = () => {
  nextTick(() => { if (messageBox.value) messageBox.value.scrollTop = messageBox.value.scrollHeight; });
};

onMounted(() => {
  fetchMessages();
  supabase
    .channel('private-chat')
    .on('postgres_changes', { event: 'INSERT', schema: 'public', table: 'messages' }, payload => {
       if (payload.new.sender_id == props.receiverId || payload.new.sender_id == props.currentUserId) {
         messages.value.push(payload.new);
         scrollToBottom();
       }
    })
    .subscribe();
});
</script>

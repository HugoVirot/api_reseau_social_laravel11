<template>
  <div class="card mb-3 p-2 w-75 mx-auto">
    <div class="row text-center">
      <h4>#{{ comment.tags }}</h4>
    </div>
    <div class="card-header row px-5 bg-light">
      <div class="col-6 text-start">
        posté par <span class="fw-bold">{{ comment.user.pseudo }}</span>
      </div>
      <div class="col-6 text-end">
        posté le {{ comment.created_at.substring(0, 10) }} à
        {{ comment.created_at.substring(11, 19) }}
      </div>
    </div>

    <div class="card-body text-center">
      <h5 class="card-title"></h5>

      <div v-if="comment.image">
        <img
          class="w-50"
          :src="`/images/${comment.image}`"
          alt="image du message"
        />
      </div>

      <p class="m-4">
        {{ comment.content }}
      </p>

      <div v-if="userStore.userLoggedIn" class="row mt-3">

        <!--********************** bouton modifier => mène à la page de modification du message ********************-->

        <!-- je ne vois le bouton "modifier" que si je suis l'auteur du commentaire ou l'admin -->
        <div class="col-6 text-center" v-if="userStore.id == comment.user_id || userStore.role == 'admin'">
          <router-link :to="`modifiercomment/${comment.id}`">
            <button class="btn btn-warning mx-auto">modifier</button>
          </router-link>
        </div>

        <!--******************************************** bouton supprimer ******************************************-->

        <!-- je ne vois le bouton "supprimer" que si je suis l'auteur du commentaire ou l'auteur du post associé ou l'admin -->
        <div class="col-6 text-center mx-auto" v-if="userStore.id == comment.user_id || userStore.id == postAuthorID || userStore.role == 'admin'">
          <button @click="deleteComment()" class="btn btn-danger">
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from "../stores/userStore";
import { useRouter } from "vue-router";

const props = defineProps(["comment", "postAuthorID"]);
const userStore = useUserStore();
const router = useRouter();

const deleteComment = async () => {
  await axios
    .delete("/api/comments/" + props.comment.id)
    .then((response) => {
      console.log("suppression réussie");
      alert("Suppression réussie !");
      router.go(0); // recharger l'accueil pour récupérer la liste des posts (router.push('/') ne recharge pas)
    })
    .catch((error) => {
      console.log(error);
      if (error.response.status == "403") {
        alert("Vous n'avez pas l'autorisation de supprimer ce commentaire !");
      } else {
        console.log(error.response);
      }
    });
};
</script>

<style scoped lang="scss">
@import "../../sass/style.scss";

.card-header {
  background-color: $mainColor !important;
  color: white;
  border: 4px solid white;
}

.card {
  color: $mainColor !important;
  background-color: $secondColor;
  border: 4px solid white;
}
</style>
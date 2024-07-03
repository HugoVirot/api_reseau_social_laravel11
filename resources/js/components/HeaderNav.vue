<template>
  <header class="sticky-top">
    <div
      class="container-fluid pt-3"
      id="headertop"
      data-bs-theme="dark"
    >
      <!-- ************************** logo ***********************-->

      <div class="d-flex flex-column mx-auto text-center">
        <router-link to="/">
          <i class="my-2 mx-auto text-white fa-3x fa-solid fa-paper-plane"></i>
        </router-link>
        <p class="text-white fs-4">Réseau Social Laravel VueJS</p>
      </div>

      <!-- hamburger -->

      <button
        class="navbar-toggler mt-3 d-md-none my-auto"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <!-- ************************** navbar ***********************-->

    <nav class="navbar navbar-expand-md navbar-light">
      <div class="container-fluid">
        <!-- liens -->

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div
            class="navbar-nav container d-md-flex justify-content-around text-center"
          >
            <router-link to="/" class="navbar-brand">accueil</router-link>

            <!-- si utilisateur connecté : mon compte / mes lieux, si pas connecté : inscription/connexion -->
            <span
              v-if="userStore.userLoggedIn"
              class="d-md-flex justify-content-between"
            >
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  {{ userStore.pseudo }}
                </a>
                <ul
                  class="dropdown-menu ms-5 ms-md-0 ps-5 ps-md-0"
                  aria-labelledby="navbarDropdownMenuLink"
                >
                  <li>
                    <router-link to="/compte" class="nav-link"
                      >mon compte</router-link
                    >
                  </li>

                  <li>
                    <router-link
                      :to="`/profil/${userStore.id}`"
                      class="nav-link"
                      >mon profil</router-link
                    >
                  </li>

                  <!-- <li v-if="userStore.role == 'admin'">
                                        <router-link to="/backoffice" class="nav-link">
                                            back-office
                                        </router-link>
                                    </li> -->
                </ul>
              </li>
              <i
                class="greenIcon fa-solid fa-right-from-bracket my-auto"
                @click="logOutUser()"
              ></i>
            </span>

            <span v-else class="d-md-flex justify-content-center">
              <router-link to="/inscription" class="nav-link me-md-3 me-lg-5"
                >inscription</router-link
              >
              <router-link to="/connexion" class="nav-link"
                >connexion</router-link
              >
            </span>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { useUserStore } from "../stores/userStore";
import { useRouter } from "vue-router";
const router = useRouter();

const userStore = useUserStore();

const logOutUser = () => {
  // on réinitialise le store
  userStore.$reset();

  axios.post("/api/logout");

  // on redirige vers l'accueil
  router.push("/");
};
</script>

<style lang="scss">
@import "../../sass/style.scss";

#headertop {
  background-color: $mainColor;
}

header {
  z-index: 1;
  background-color: $secondColor;
}
</style>

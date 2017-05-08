<template>
    <div id="app">
        <nprogress-container></nprogress-container>
        <navbar :show="true"></navbar>
        <sidebar :show="sidebar.opened && !sidebar.hidden"></sidebar>
        <app-main></app-main>
        <footer-bar></footer-bar>
    </div>
</template>

<script>
    import NprogressContainer from 'vue-nprogress/src/NprogressContainer.vue'
    import { Navbar, Sidebar, AppMain, FooterBar } from './components/layouts'
    import { mapGetters, mapActions } from 'vuex'
    export default {
        components: {
            NprogressContainer,
            Navbar,
            Sidebar,
            AppMain,
            FooterBar
        },

        beforeMount() {
            const { body } = document;
            const WIDTH = 768;
            const RATIO = 3;

            // 窗口改变处理器
            const handler = () => {
                if (!document.hidden) {
                    let rect = body.getBoundingClientRect();
                    let isMobile = rect.width - RATIO < WIDTH;
                    this.toggleDevice(isMobile ? 'mobile' : 'other');
                    this.toggleSidebar(!isMobile)
                }
            };

            // 添加请求回复拦截
            this.$http.interceptors.response.use(function (response) {
                  return response;
              }, (error) => {
                  if (error.response) {
                      const resp = error.response;
                      if (resp.status === 404) {
                          this.$message.warning('没有找到您请求的资源');
                      }
                      if (resp.status === 403) {
                          this.$notify.warning('您没有该操作的权限!');
                      }
                      if (resp.status === 401) {
                          this.$notify.warning('会话已过期，请重新登录');
                      }
                  } else {
                      this.$notify.error('对方不想理你，并向你抛了个异常');
                  }

                  return Promise.reject(error);
              });

            // 判断窗口改变的事件监听
            document.addEventListener('visibilitychange', handler);
            window.addEventListener('DOMContentLoaded', handler);
            window.addEventListener('resize', handler);
        },

        computed: mapGetters({
            sidebar: 'sidebar'
        }),

        methods: mapActions([
            'toggleDevice',
            'toggleSidebar'
        ])

    }
</script>

<style lang="scss" rel="stylesheet/scss">
    .animated {
        animation-direction: .377s;
    }

    html {
        background-color: whitesmoke;
    }

    .nprogress-container {
        position: fixed !important;
        width: 100%;
        height: 50px;
        z-index: 2048;
        pointer-events: none;

        #nprogress {
            $color: #48e79a;

            .bar {
                background: $color;
            }
            .peg {
                box-shadow: 0 0 10px $color, 0 0 5px $color;
            }

            .spinner-icon {
                border-top-color: $color;
                border-left-color: $color;
            }
        }


    }
</style>
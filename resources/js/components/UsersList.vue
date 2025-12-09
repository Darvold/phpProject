<template>
    <!-- Правая колонка: Список пользователей -->
    <div class="users-list-section">
        <div class="list-card">
            <div class="list-header">
                <h3 class="list-title">Список пользователей</h3>
                <div class="list-actions">
                    <button class="btn-add-user" @click="addUser">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Добавить
                    </button>
                    <div class="search-box">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <input
                            type="text"
                            class="search-input"
                            placeholder="Поиск пользователей..."
                            v-model="searchQuery"
                            @input="filterUsers"
                        >
                    </div>
                </div>
            </div>

            <div class="users-table">
                <div class="table-header">
                    <div class="table-row header-row">
                        <div class="table-cell">ФИО</div>
                        <div class="table-cell">Email</div>
                        <div class="table-cell">Роль</div>
                        <div class="table-cell">Статус</div>
                        <div class="table-cell">Действия</div>
                    </div>
                </div>

                <div class="table-body">
                    <!-- Другие пользователи -->
                    <div
                        class="table-row user-row"
                        v-for="user in filteredUsers"
                        :key="user.id"
                        :class="{ selected: selectedUser && selectedUser.id === user.id }"
                        @click="selectUser(user)"
                    >
                        <div class="table-cell">
                            <div class="user-cell">
                                <div class="user-avatar-small">{{ getInitials(user.fio) }}</div>
                                <div class="user-info-cell">
                                    <div class="user-name">{{ user.fio }}</div>
                                    <div class="user-email-small">{{ user.email }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="table-cell">{{ user.email }}</div>
                        <div class="table-cell">
                            <span :class="getRoleBadgeClass(user.role)">
                                {{ getRoleName(user.role) }}
                            </span>
                        </div>
                        <div class="table-cell">
                            <span :class="['status-indicator', { active: user.is_active }]"></span>
                            {{ user.is_active ? 'Активен' : 'Не активен' }}
                        </div>
                        <div class="table-cell">
                            <div class="action-buttons">
                                <button class="btn-action edit" @click.stop="editUser(user)">✏️</button>
                                <button class="btn-action delete" @click.stop="deleteUser(user)">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-footer">
                <div class="pagination">
                    <button
                        v-for="page in totalPages"
                        :key="page"
                        class="pagination-btn"
                        :class="{ active: currentPage === page }"
                        @click="changePage(page)"
                    >
                        {{ page }}
                    </button>
                    <span class="pagination-dots" v-if="totalPages > 5">...</span>
                </div>
                <div class="total-users">
                    Всего пользователей: <strong>{{ filteredUsers.length }}</strong>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UsersList',

    props: {
        // Принимаем данные из PHP
        initialUsers: {
            type: Array,
            default: () => []
        },
        perPage: {
            type: Number,
            default: 10
        }
    },

    data() {
        return {
            users: this.initialUsers,
            searchQuery: '',
            currentPage: 1,
            selectedUser: null,
            filteredUsers: this.initialUsers
        }
    },

    computed: {
        totalPages() {
            return Math.ceil(this.filteredUsers.length / this.perPage);
        },

        paginatedUsers() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredUsers.slice(start, end);
        }
    },

    watch: {
        initialUsers: {
            immediate: true,
            handler(newUsers) {
                this.users = newUsers;
                this.filterUsers();
            }
        }
    },

    methods: {
        getInitials(fio) {
            if (!fio) return '';
            const parts = fio.split(' ');
            let initials = '';
            if (parts[0]) initials += parts[0].charAt(0);
            if (parts[1]) initials += parts[1].charAt(0);
            return initials || fio.charAt(0);
        },

        getRoleName(roleId) {
            const roles = {
                1: 'Пользователь',
                2: 'Администратор',
                3: 'Модератор'
            };
            return roles[roleId] || 'Неизвестно';
        },

        getRoleBadgeClass(roleId) {
            const classes = {
                1: 'role-badge user',
                2: 'role-badge admin',
                3: 'role-badge moderator'
            };
            return classes[roleId] || 'role-badge user';
        },

        filterUsers() {
            if (!this.searchQuery.trim()) {
                this.filteredUsers = this.users;
                return;
            }

            const query = this.searchQuery.toLowerCase();
            this.filteredUsers = this.users.filter(user => {
                return user.fio.toLowerCase().includes(query) ||
                    user.email.toLowerCase().includes(query);
            });

            this.currentPage = 1;
        },

        selectUser(user) {
            this.selectedUser = user;
            this.$emit('user-selected', user);
        },

        addUser() {
            this.$emit('add-user');
        },

        editUser(user) {
            this.$emit('edit-user', user);
        },

        deleteUser(user) {
            if (confirm(`Удалить пользователя ${user.fio}?`)) {
                this.$emit('delete-user', user);
            }
        },

        changePage(page) {
            this.currentPage = page;
        }
    }
}
</script>

import mitt from 'mitt';

const emitter = mitt();

export const eventBus = {
    emit: emitter.emit,
    on: emitter.on,
    off: emitter.off
};

// Специальные события для поиска
export const SEARCH_EVENTS = {
    RESET_SEARCH: 'reset-search',
    SEARCH_USERS: 'search-users',
    USERS_UPDATED: 'users-updated'
};

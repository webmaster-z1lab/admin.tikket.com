import * as types from './mutation-types'

export default {
    changeLoading(context, payload) {
        context.commit(types.CHANGE_LOADING, payload)
    },
    setOrder(context, payload) {
        context.commit(types.SET_ORDER, payload)
    },
    setItems(context, payload) {
        context.commit(types.SET_ITEMS, payload)
    },
    initEvent(context, payload) {
        context.dispatch('changeLoading', false)
        context.commit(types.INIT_EVENT, JSON.parse(payload))
    }
}

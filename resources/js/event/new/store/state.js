export default {
    start_event: true,
    event: {
        attributes: {},
        relationships: {
            producer: {
                attributes: {}
            }
        }
    },
    ticket: {
        id: null,
        name: '',
        summary: '',
        starts_at: false,
        quant_min: 1,
        quant_max: 5,
        category: '',
        secondary_category: '',
        description: ''
    }
}

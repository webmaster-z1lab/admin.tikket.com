export default {
    start_event: true,
    event: {
        attributes: {
            is_public: true
        },
        relationships: {
            entrances: [],
            producer: {
                attributes: {}
            }
        }
    },
    ticket: {
        id: null,
        name: '',
        free_ticket: false,
        summary: '',
        starts_at: '',
        quant_min: 1,
        quant_max: 5,
        lots: [
            {
                amount: '',
                finishes_at: '',
                value: 0
            }
        ]
    }
}

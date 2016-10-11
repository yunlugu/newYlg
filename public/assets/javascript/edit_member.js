var editApp = new Vue({
    el: '#app',
    data: {
        departments: '',
        selected_department: newYlg.currentDepartment,
        groups: '',
        selected_group: newYlg.currentGroup

    },

    created: function () {
        this.fetchDepartments();
        console.log('created');
    },

    ready: function () {
        this.fetchDepartments();
        console.log('beforeCompile');
    },

    methods: {
        fetchDepartments: function () {
            this.$http.get(newYlg.fetchDepartmentsRoute).then(function (res) {
                this.departments = res.data;
                console.log(res);
            }, function () {
                console.log('Failed to fetch departments')
            });
        },
        fetchGroups: function () {
            console.log('hahah');
            this.$http.get(newYlg.fetchGroupsRoute + '/' + this.selected_department).then(function (res) {
                this.groups = res.data;
                jQuery.each(this.groups, function(value) {
                    console.log(value);
                })
            }, function () {
                console.log('Failed to fetch groups')
            });
        }

    }
});

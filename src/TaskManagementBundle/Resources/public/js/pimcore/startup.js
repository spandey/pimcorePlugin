pimcore.registerNS("pimcore.plugin.TaskManagementBundle");

pimcore.plugin.TaskManagementBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.TaskManagementBundle";
    },

    initialize: function () {
        //alert("____dd");
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        //alert("____sssdd");
       //alert("TaskManagementBundle ready!");
       this.addMenuIntools(this);
    },
    addMenuIntools: function (scope) {
        var navigation = Ext.get("pimcore_menu_extras");
         var user = pimcore.globalmanager.get("user");
        var userPermissions = user.permissions;
        
        if (user.admin == true ) {
           // var ulElement = navigation.selectNode('ul');
            var li = document.createElement("li");

            li.setAttribute("id", "task_manegment_menu");
            li.setAttribute("class", "pimcore_menu_mds pimcore_menu_item pimcore_menu_needs_children");
           
            li.setAttribute("data-menu-tooltip", "Task Management");
            navigation.insertSibling(li,'after');
            pimcore.helpers.initMenuTooltips();
            Ext.get("task_manegment_menu").on("click", function (e, el) {
               
               scope.showTab();
            });
        } else {
            return false;
        }

/*var user = pimcore.globalmanager.get("user");
var perspectiveCfg = pimcore.globalmanager.get("perspective");
if (perspectiveCfg.inToolbar("extras")) {

            var extrasItems = [];

            if (user.isAllowed("taskmanagement") && perspectiveCfg.inToolbar("extras.taskmanagement")) {
                extrasItems.push({
                    text: t("taskmanagement"),
                    iconCls: "pimcore_icon_glossary",
                    handler: ""
                });
               
            }
            
            if (extrasItems.length > 0) {
                this.extrasMenu = new Ext.menu.Menu({
                    items: extrasItems,
                    shadow: false,
                    cls: "pimcore_navigation_flyout"
                });
               
            }
            if (this.extrasMenu) {
                var toolbar = pimcore.globalmanager.get("layout_toolbar");
                Ext.get("pimcore_menu_extras").on("mousedown", toolbar.showSubMenu.bind(this.extrasMenu));
        }
    }*/
     
    },
     /*showSubMenus: function (e) {
        if(this.hidden) {
            e.stopEvent();
            var el = Ext.get(e.currentTarget);
            var offsets = el.getOffsetsTo(Ext.getBody());
            offsets[0] = 60;
            this.showAt(offsets);
        } else {
            this.hide();
        }
    },*/
    
    showTab: function() {
       TaskManagementBundlePlugin.panel = new Ext.Panel({
            id:         "task_manager_panel",
            title:      "Task Manager",
            border:     false,
            layout:     "fit",
            closable:   true,
            items:      [TaskManagementBundlePlugin.getGrid()]
        });

        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.add(TaskManagementBundlePlugin.panel);
        tabPanel.setActiveTab(TaskManagementBundlePlugin.panel);
        
        pimcore.layout.refresh();
    },
    getGrid: function () {
        var ryc = pimcore.globalmanager.get("layout_toolbar");
        var itemsPerPage = pimcore.helpers.grid.getDefaultPageSize();
        this.store = pimcore.helpers.grid.buildDefaultStore(
            '/admin/recyclebin/list?',
            [
                {name: 'id'},
                {name: 'type'},
                {name: 'subtype'},
                {name: 'path'},
                {name: 'amount'},
                {name: 'deletedby'},
                {name: 'date'}
            ],
            itemsPerPage
        );
        this.store.getProxy().setBatchActions(false);

        this.store.addListener('load', function () {
            if (this.store.getCount() > 0) {
                Ext.getCmp("pimcore_recyclebin_button_flush").enable();
            }
        }.bind(this));


        this.filterField = new Ext.form.TextField({
            xtype: "textfield",
            width: 200,
            style: "margin: 0 10px 0 0;",
            enableKeyEvents: true,
            listeners: {
                "keydown": function (field, key) {
                    if (key.getKey() == key.ENTER) {
                        var input = field;
                        var proxy = this.store.getProxy();
                        proxy.extraParams.filterFullText = input.getValue();
                        this.store.load();
                    }
                }.bind(this)
            }
        });

        this.pagingtoolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(this.store);

        var typesColumns = [
            {
                text: t("type"), width: 50, sortable: true, dataIndex: 'subtype', renderer: function (d) {
                    return '<img src="/pimcore/static6/img/flat-color-icons/' + d + '.svg" style="height: 16px" />';
                }
            },
            {text: t("path"), flex: 200, sortable: true, dataIndex: 'path', filter: 'string'},
            {text: t("amount"), flex: 60, sortable: true, dataIndex: 'amount'},
            {text: t("deletedby"), flex: 80, sortable: true, dataIndex: 'deletedby', filter: 'string'},
            {
                text: t("date"), flex: 140, sortable: true, dataIndex: 'date',
                renderer: function (d) {
                    var date = new Date(d * 1000);
                    return Ext.Date.format(date, "Y-m-d H:i:s");
                },
                filter: 'date'

            },
            {
                xtype: 'actioncolumn',
                menuText: t('delete'),
                width: 30,
                items: [{
                    tooltip: t('delete'),
                    icon: "/pimcore/static6/img/flat-color-icons/delete.svg",
                    handler: function (grid, rowIndex) {
                        grid.getStore().removeAt(rowIndex);
                    }.bind(this)
                }]
            }
        ];

        var toolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar',
            items: [
                {
                    text: t('Add Task'),
                    handler: "",//this.restoreSelected.bind(this),
                    iconCls: "pimcore_icon_restore",
                    id: "pimcore_recyclebin_button_restore",
                    disabled: true
                }, '-', {
                    text: t('delete_selected'),
                    handler: "",//this.deleteSelected.bind(this),
                    iconCls: "pimcore_icon_delete",
                    id: "pimcore_recyclebin_button_delete",
                    disabled: true
                }, "-",
                {
                    text: t('flush_recyclebin'),
                    handler: "",//this.onFlush.bind(this),
                    iconCls: "pimcore_icon_flush_recyclebin",
                    id: "pimcore_recyclebin_button_flush",
                    disabled: true
                },
                '->', {
                    text: t("filter") + "/" + t("search"),
                    xtype: "tbtext",
                    style: "margin: 0 10px 0 0;"
                },
                this.filterField
            ]
        });

        this.selectionColumn = new Ext.selection.CheckboxModel();
       // this.selectionColumn.on("selectionchange", this.updateButtonStates.bind(this));

        this.grid = new Ext.grid.GridPanel({
            frame: false,
            autoScroll: true,
            store: this.store,
            columnLines: true,
            bbar: this.pagingtoolbar,
            stripeRows: true,
            selModel: this.selectionColumn,
            plugins: ['pimcore.gridfilters'],
            columns: typesColumns,
            tbar: toolbar,
            listeners: {
                "rowclick": ""//this.updateButtonStates.bind(this)
            },
            viewConfig: {
                forceFit: true
            }
        });

        //this.grid.on("rowcontextmenu", this.onRowContextmenu.bind(this));

        return this.grid;
    },
});

var TaskManagementBundlePlugin = new pimcore.plugin.TaskManagementBundle();

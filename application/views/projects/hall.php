
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/projects.css') ?>">
<?php if ($progress != 0) { ?>
    <style>
        .edit-area[data-type="edit"] .input-area {
            text-align: left;
            width: 24%;
        }

        .edit-area[data-type="edit"] .input-area.textarea label {
            width: 100px;
        }

        .edit-area[data-type="edit"] .input-area label {
            font-size: 18px;
            font-weight: 500;
            white-space: normal;
            word-break: break-all;
            max-width: 85%;
            vertical-align: top;
        }

        .edit-area[data-type="edit"] .edit-container .input-area:first-child label,
        .edit-area[data-type="edit"] .edit-container .input-area:nth-child(2) label {
            margin-left: 0;
            vertical-align: baseline;
        }

        .edit-area[data-type="edit"] .edit-container .input-area:first-child,
        .edit-area[data-type="edit"] .edit-container .input-area:nth-child(2) {
            min-width: 24%;
            width: auto;
        }

        .edit-area[data-type="edit"] .edit-container .input-area:first-child label:first-child,
        .edit-area[data-type="edit"] .edit-container .input-area:nth-child(2) label:first-child {
            margin: 0 0px 0 30px;
            font-size: 38px;
        }

        .edit-area[data-type="edit"] .edit-container .input-area.textarea {
            width: auto;
        }
    </style>
<?php } ?>
<div class="base-container">
    <div class="nav-position-title"></div>
    <form class="search-form"
          action="<?= base_url($apiRoot); ?>" method="post">
        <div class="tab-container">
            <!--            <div class="tab-item" data-type="all" data-sel="1">全部-->
            <!--                <div class="tab-number">9</div>-->
            <!--            </div>-->
            <div class="tab-item" data-progress="0">未开始
                <div class="tab-number">0</div>
            </div>
            <div class="tab-item" data-progress="1">进行中
                <div class="tab-number">0</div>
            </div>
            <div class="tab-item" data-progress="2">待验收
                <div class="tab-number">999<sup>+</sup></div>
            </div>
            <div class="tab-item" data-progress="3">已完成
                <div class="tab-number">999<sup>+</sup></div>
            </div>
            <input style="display:none;" name="_progress"/>
            <?php if (false) { ?>
                <div class="tab-search" style="justify-content: flex-start;padding-left: 15px;">
                    <div class="input-area">
                        <div class="btn-circle btn-blue" style="font-size: 16px;" onclick="editItem();">
                            <i class="fa fa-plus"></i> 新增项目
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="tab-search">
                <div class="input-area" style="padding-left: 15px;">
                    <input name="search_keyword" placeholder="请输入内容"/>
                    <div class="btn-fontgrey" onclick="searchItems();"><i class="fa fa-search"></i></div>
                </div>
                <!--                <div class="btn-back btn-grey btn-fontgrey"><i class="fa fa-angle-left"></i></div>-->
            </div>
        </div>
    </form>
    <div class="content-area">
        <div class="content-table"><?= $tbl_content; ?></div>
        <div class="content-pagination">
            <?php echo $this->pagination->create_links(); ?>
            <div class="scripts">
                <script>
                    appendPagination('<?= $curPage; ?>', '<?= $perPage; ?>',
                        '<?= $cntPage; ?>', '<?= $apiRoot; ?>');
                </script>
            </div>
        </div>
    </div>
    <div class="edit-area" data-type="view">
        <div class="content-title"><span></span>
            <div>
                <div style="text-align: right; margin-right: 50px;font-size: 20px;">
                    项目编号: <label name="no"></label>
                </div>
                <div class="btn-circle btn-grey" data-type="close-panel">
                    <i class="fa fa-angle-left"></i></div>
            </div>
        </div>
        <div class="edit-container">
            <div class="input-area">
                <label name="total_score"></label>
                <label>(分) 项目总分</label>
            </div>
            <div class="input-area">
                <label name="worker"></label>
                <label>项目负责人</label>
            </div>
            <div class="input-area">
                <label name="score"></label>
                <label>项目剩余分数</label>
            </div>
            <br>
            <div class="input-area">
                <label>项目名称:</label>
                <label name="title"></label>
            </div>
<!--            <div class="input-area">-->
<!--                <label>项目金额:</label>-->
<!--                <label name="init_price"></label>-->
<!--            </div>-->
<!--            <div class="input-area">-->
<!--                <label>合同金额:</label>-->
<!--                <label name="work_price"></label>-->
<!--            </div>-->
            <div class="input-area">
                <label>项目发布时间:</label>
                <label name="published_at"></label>
            </div>
            <?php if ($progress > 0) { ?>
                <div class="input-area">
                    <label>项目开始时间:</label>
                    <label name="started_at"></label>
                </div>
            <?php } ?>
            <?php if ($progress > 1) { ?>
                <div class="input-area">
                    <label>项目提交时间:</label>
                    <label name="provided_at"></label>
                </div>
            <?php } ?>
            <?php if ($progress > 2) { ?>
                <div class="input-area">
                    <label>项目验收时间:</label>
                    <label name="completed_at"></label>
                </div>
            <?php } ?>
            <div class="input-area">
                <label>项目截止日期:</label>
                <label name="deadline"></label>
            </div>
            <br>
            <div class="input-area textarea">
                <label>项目描述:</label>
                <label name="description"></label>
            </div>
        </div>
        <div class="edit-container" style="border:none;padding:0 80px;">
            <?php if ($progress == 0) { ?>
<!--                <div class="input-area" style="margin: 0;text-align: center;">-->
<!--                    <div class="btn-rect btn-blue" name="btns" style="width: 210px;" onclick="deleteItem(this);">删除-->
<!--                    </div>-->
<!--                </div>-->
            <?php } else { ?>
                <div class="input-area" style="margin: 0;text-align: center;">
                    <div class="btn-rect btn-blue" name="btns" style="width: 210px;" onclick="viewTasks(this);">查看任务
                    </div>
                </div>
            <?php } ?>
            <?php if ($progress == 0 || $progress == 1) { ?>
<!--                <div class="input-area" style="margin: 0;text-align: center;">-->
<!--                    <div class="btn-rect btn-blue" name="btns" style="width: 210px;" onclick="editItem(this);">编辑项目-->
<!--                    </div>-->
<!--                </div>-->
            <?php } else if ($progress == 2) { ?>
<!--                <div class="input-area" style="margin: 0;text-align: center;">-->
<!--                    <div class="btn-rect btn-blue" name="btns" style="width: 210px;" onclick="completeItem(this);">-->
<!--                        确认验收-->
<!--                    </div>-->
<!--                </div>-->
            <?php } ?>
        </div>
    </div>
    <div class="edit-area" data-type="edit">
        <div class="content-title"><span></span>
            <div>
                <?php if ($progress != 0) { ?>
                    <div style="text-align: right; margin-right: 50px;font-size: 20px;">
                        项目编号: <label name="no"></label>
                    </div>
                <?php } ?>
                <div class="btn-circle btn-grey" data-type="close-panel">
                    <i class="fa fa-angle-left"></i></div>
            </div>
        </div>
        <form class="edit-form" action="" method="post">
            <div class="edit-container">
                <?php if ($progress != 0) { ?>
                    <div class="input-area">
                        <label name="total_score"></label>
                        <label>(分) 项目总分</label>
                    </div>
                    <div class="input-area">
                        <label name="worker"></label>
                        <label>项目负责人</label>
                    </div><br>
                <?php } else { ?>
                    <div class="input-area">
                        <label>项目编号:</label>
                        <input name="no" placeholder="请输入项目编号" type="text"/>
                    </div>
                <?php } ?>
                <div class="input-area">
                    <label>项目名称:</label>
                    <?php if ($progress == 0) { ?>
                        <input name="title" placeholder="请输入项目名称" type="text"/>
                    <?php } else { ?>
                        <label name="title"></label>
                    <?php } ?>
                </div>
                <?php if ($progress == 0) { ?>
                    <div class="input-area">
                        <label>项目负责人:</label>
                        <div class="tree-search" data-width="315">
                            <select name="worker_id" placeholder="请选择"></select>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-area">
                    <label>项目金额:</label>
                    <?php if ($progress == 0) { ?>
                        <input name="init_price" placeholder="请输入项目金额" type="number"/>
                        <div class="input-group-addon">￥</div>
                    <?php } else { ?>
                        <label name="init_price"></label>
                    <?php } ?>
                </div>
                <div class="input-area">
                    <label>合同金额:</label>
                    <?php if ($progress == 0) { ?>
                        <input name="work_price" placeholder="请输入合同金额" type="number"/>
                        <div class="input-group-addon">￥</div>
                    <?php } else { ?>
                        <label name="work_price"></label>
                    <?php } ?>
                </div>
                <?php if ($progress == 0) { ?>
                    <div class="input-area">
                        <label>项目截止日期:</label>
                        <input class="date-picker" name="deadline" placeholder="请选择日期" type="text"
                               data-date-format="YYYY-MM-DD hh:mm:ss"/>
                        <div class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></div>
                    </div>
                    <div class="input-area">
                        <label>项目总分:</label>
                        <input name="total_score" placeholder="请输入项目总分" type="number"/>
                    </div><br>
                <?php } else { ?>
                    <div class="input-area">
                        <label>项目开始日期:</label>
                        <label name="started_at"></label>
                    </div><br>
                    <div class="input-area" style="width: auto;">
                        <label style="vertical-align: middle;">项目截止日期:</label>
                        <input class="date-picker" name="deadline" placeholder="请选择日期" type="text"
                               data-date-format="YYYY-MM-DD hh:mm:ss"/>
                        <div class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></div>
                    </div><br>
                <?php } ?>
                <div class="input-area textarea">
                    <label>项目描述:</label>
                    <textarea name="description" placeholder="请输入内容"></textarea>
                </div>
            </div>
        </form>
        <div class="edit-container" style="border:none;padding:0 125px;">
            <div class="input-area" style="margin: 0;text-align: center;">
                <div class="btn-rect btn-blue" style="width: 210px;" onclick="editPerform('.edit-form');">保存</div>
            </div>
        </div>
    </div>
    <form class="useraction-form" action="" method="post" hidden style="display:none;">
        <input name="search_keyword" style="display: none!important;" value="<?= $search_keyword; ?>"/>
        <input name="range_from" style="display: none!important;" value="<?= $range_from; ?>"/>
        <input name="range_to" style="display: none!important;" value="<?= $range_to; ?>"/>
    </form>
</div>


<div class="scripts">
    <input hidden class="_userList" value='<?= str_replace("'","`",json_encode($userList)) ?>'>
    <input hidden class="_taskList" value='<?= str_replace("'","`",json_encode($taskList)) ?>'>
    <input hidden class="_mainList" value='<?= str_replace("'","`",json_encode($list)) ?>'>
    <input hidden class="_progressCnt" value='<?= json_encode($progressCnt) ?>'>
    <input hidden class="_filterInfo"
           value='<?= json_encode($this->session->userdata('filter') ?: array()) ?>'>

    <script>
        selectMenu('<?= $menu; ?>');
        $(function () {
            searchConfig();
        });

        var _userList = JSON.parse($('._userList').val());
        _userList = _userList.filter(function (a) {
            a.title = a.name;
            return true;
        });
        var _mainList = JSON.parse($('._mainList').val());
        var _taskList = JSON.parse($('._taskList').val());
        var _progressCnt = JSON.parse($('._progressCnt').val());
        var _filterInfo = JSON.parse($('._filterInfo').val());
        var _mainObj = '<?=$mainModel?>';
        var _apiRoot = baseURL + "<?=$apiRoot?>".split('/')[0] + '/';
        var _navTitle = '<?= $title; ?>';
        var _progress = parseInt('<?= $progress ?>');
        var _titleStr = ['未开始', '进行中', '待验收', '已完成'];
        var _editItemId = 0;

        function searchConfig() {
            if (_filterInfo.queryStr) $('input[name="search_keyword"]').val(_filterInfo.queryStr);
            if (_filterInfo[_mainObj + '.part_id']) $('select[name="search_part"]').val(_filterInfo[_mainObj + '.part_id']);

            var tabElems = $('.tab-container');
            tabElems.find('.tab-item').each(function (idx, elem) {
                elem = $(elem);
                elem.off('click');
                elem.on('click', function () {
                    var that = $(this);
                    var progress = parseInt(that.attr('data-progress'));
                    if (progress != _progress) {
                        $('input[name="_progress"]').val(progress);
                        location.replace(_apiRoot + 'hall/<?= $menu ?>/' + progress);
                    }
                });

                var suff = parseInt(_progressCnt[idx]);
                if (suff > 999) suff = '999<sup>+</sup>';
                elem.find('.tab-number').html(suff);
                elem.find('.tab-number').attr('data-value',suff);
            })


            $('input[name="_progress"]').val(_progress);
            _navTitle += ' ＞ ' + _titleStr[_progress];
            tabElems.find('.tab-item[data-progress="' + _progress + '"]').attr('data-sel', 1);

            $('.base-container .nav-position-title').html(_navTitle);
        }

        function searchItems() {
            $('.search-form').submit();
        }

        function viewTasks(elem) {
            var that = $(elem);
            var projectId = that.attr('data-id');
            setPreviousKeyword($('input[name="search_keyword"]').val());
            setSearchKeyword(window.location);
            $('input[name="search_keyword"]').val('');
            $('input[name="range_from"]').val('');
            $('input[name="range_to"]').val('');
            $('.useraction-form').attr('action', baseURL+'tasks/viewlist/<?= $menu ?>/'+projectId);
            $('.useraction-form').submit();
        }

        function viewItem(elem) {
            $('.edit-area').hide();
            var editElem = $('.edit-area[data-type="view"]');

            $('div[data-type="close-panel"]').off('click');
            $('div[data-type="close-panel"]').on('click', function () {
                $('.base-container .nav-position-title').html(_navTitle);
                editElem.fadeOut('fast');
            });
            var headerTitle = '项目简介';
            var that = $(elem);
            var id = that.attr('data-id');
            var mainItem = _mainList.filter(function (a) {
                return a.id == id;
            });
            if (mainItem.length > 0) {
                mainItem = mainItem[0];
                _editItemId = mainItem.id;
                editElem.find('label[name="no"]').html(mainItem.no);
                editElem.find('label[name="title"]').html(mainItem.title);
                editElem.find('label[name="worker"]').html(mainItem.worker);
                editElem.find('label[name="init_price"]').html('￥' + mainItem.init_price);
                editElem.find('label[name="work_price"]').html('￥' + mainItem.work_price);
                editElem.find('label[name="started_at"]').html(mainItem.started_at);
                editElem.find('label[name="published_at"]').html(mainItem.published_at);
                editElem.find('label[name="provided_at"]').html(mainItem.provided_at);
                editElem.find('label[name="completed_at"]').html(mainItem.completed_at);
                editElem.find('label[name="total_score"]').html(mainItem.total_score);
                editElem.find('label[name="deadline"]').html(mainItem.deadline);
                editElem.find('label[name="description"]').html(mainItem.description);
                editElem.find('div[name="btns"]').attr('data-id', mainItem.id);

                var allTasks = _taskList.filter(function (a) {
                    return a.project_id == mainItem.id;
                });
                var taskScore = 0;
                for (var i = 0; i < allTasks.length; i++) {
                    taskScore += allTasks[i].score * 1;
                }
                editElem.find('label[name="score"]').html((mainItem.total_score - taskScore).toFixed(2));
            }

            editElem.find('.content-title > span').html(headerTitle);
            $('.base-container .nav-position-title').html(_navTitle + ' ＞ ' + headerTitle);

            editElem.fadeIn('fast');
        }

        function editItem(elem) {
            $('.edit-area[data-type="view"]').fadeOut();
            var editElem = $('.edit-area[data-type="edit"]');
            makeTreeSearchSelect(editElem.find('select[name="worker_id"]'), _userList,
                '', 'part', 'id', 'title', function (e) {
                    var that = editElem.find('select[name="worker_id"]');
                    var id = that.val();
                });

            $('div[data-type="close-panel"]').off('click');
            $('div[data-type="close-panel"]').on('click', function () {
                $('.base-container .nav-position-title').html(_navTitle);
                editElem.fadeOut('fast');
            });
            var headerTitle = '新增项目';
            if (!elem) {
                editElem.find('input').val('');
                editElem.find('select').val('');
                editElem.find('textarea').val('');
                _editItemId = 0;
            } else {
                headerTitle = '编辑项目';
                var that = $(elem);
                var id = that.attr('data-id');
                var mainItem = _mainList.filter(function (a) {
                    return a.id == id;
                });
                if (mainItem.length > 0) {
                    mainItem = mainItem[0];
                    _editItemId = mainItem.id;
                    editElem.find('input[name="no"]').val(mainItem.no);
                    editElem.find('input[name="title"]').val(mainItem.title);
                    editElem.find('select[name="worker_id"]').val(mainItem.worker_id);
                    editElem.find('input[name="init_price"]').val(mainItem.init_price);
                    editElem.find('input[name="work_price"]').val(mainItem.work_price);
                    editElem.find('input[name="total_score"]').val(mainItem.total_score);

                    editElem.find('label[name="no"]').html(mainItem.no);
                    editElem.find('label[name="title"]').html(mainItem.title);
                    editElem.find('label[name="worker"]').html(mainItem.worker);
                    editElem.find('label[name="init_price"]').html('￥' + mainItem.init_price);
                    editElem.find('label[name="work_price"]').html('￥' + mainItem.work_price);
                    editElem.find('label[name="started_at"]').html(mainItem.started_at);
                    editElem.find('label[name="published_at"]').html(mainItem.published_at);
                    editElem.find('label[name="total_score"]').html(mainItem.total_score);

                    editElem.find('input[name="deadline"]').val(mainItem.deadline);
                    editElem.find('textarea[name="description"]').val(mainItem.description);

                    editElem.find('input[name="deadline"]').handleDtpicker('setDate', makeDateObject(mainItem.deadline));

                    // tree_select();
                    tree_search();
                }
            }

            editElem.find('.content-title span').html(headerTitle);
            $('.base-container .nav-position-title').html(_navTitle + ' ＞ ' + headerTitle);

            editElem.fadeIn('fast');
        }

        var _isProcessing = false;

        function editPerform(elem) {
            var that = $(elem);

            if (_isProcessing) return;
            _isProcessing = true;
            $('.modal-container[data-type="modal"]').fadeIn('fast');
            $(".uploading-progress").fadeIn('fast');

            var fdata = new FormData(that[0]);
            fdata.append("id", _editItemId);
            $.ajax({
                url: _apiRoot + "updateItem",
                type: "POST",
                data: fdata,
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                xhr: function () {
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function (event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            $(".progress-val").html(percent + '%');
                        }, true);
                    }
                    return xhr;
                },
                mimeType: "multipart/form-data"
            }).done(function (res) { //
                var ret;
                $('.modal-container[data-type="modal"]').fadeOut('fast');
                $(".uploading-progress").fadeOut('fast');

                _isProcessing = false;
                try {
                    ret = JSON.parse(res);
                } catch (e) {
                    alert('操作失败 : ' + JSON.stringify(e));
                    console.log(res);
                    return;
                }
                if (ret.status == 'success') {
                    location.reload();
                } else { //failed
                    alert('操作失败 : ' + ret.data);
                }
            });
        }

        function resetItem(elem) {
            var that = $(elem);
            var id = that.attr('data-id');
            showConfirm(baseURL + 'assets/images/modal/modal-confirm-top.png',
                '', '是否重置密码?', function () {
                    $.ajax({
                        type: "post",
                        url: _apiRoot + "resetItem",
                        dataType: "json",
                        data: {id: id},
                        success: function (res) {
                            if (res.status == 'success') {
                                showNotify('<i class="fa fa-check"></i> 密码重置成功');
                                // location.reload();
                            } else { //failed
                                alert(res.data);
                            }
                        }
                    });
                }
            );
        }

        function deleteItem(elem) {
            var that = $(elem);
            var id = that.attr('data-id');
            showConfirm(baseURL + 'assets/images/modal/modal-confirm-top.png',
                '', '您确定要删除这个项目吗?', function () {
                    $.ajax({
                        type: "post",
                        url: _apiRoot + "deleteItem",
                        dataType: "json",
                        data: {id: id},
                        success: function (res) {
                            if (res.status == 'success') {
                                showNotify('<i class="fa fa-check"></i> 删除成功');
                                setTimeout(function () {
                                    //location.reload();
                                }, 1000);
                                // location.reload();
                            } else { //failed
                                alert(res.data);
                            }
                        }
                    });
                }
            );
        }

        function completeItem(elem) {
            var that = $(elem);
            var id = that.attr('data-id');
            showConfirm(baseURL + 'assets/images/modal/modal-confirm-top.png',
                '', '确定验收通过这个项目么?', function () {
                    $.ajax({
                        type: "post",
                        url: _apiRoot + "completeItem",
                        dataType: "json",
                        data: {id: id},
                        success: function (res) {
                            if (res.status == 'success') {
                                showNotify('<i class="fa fa-check-circle" style="padding-right:0;"></i><br>' +
                                    '<span style="font-size:18px;">项目已成功提交</span>');
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                                // location.reload();
                            } else { //failed
                                alert(res.data);
                            }
                        }
                    });
                }
            );
        }
    </script>
</div>
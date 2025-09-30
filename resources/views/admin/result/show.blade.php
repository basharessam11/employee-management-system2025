@extends('admin.layout.app')

@section('page', __('admin.DepartmentUser_Management'))

@section('contant')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row g-4">
                <div class="col-12 col-lg-12 pt-4 pt-lg-0">
                    <div class="card mb-4">


                        <script>
                            function printCard() {
                                var printContents = document.getElementById("printArea").innerHTML;
                                var originalContents = document.body.innerHTML;

                                // استبدال الصفحة كاملة بمحتوى الكارد
                                document.body.innerHTML = printContents;

                                window.print();

                                // رجوع المحتوى الأصلي بعد الطباعة
                                document.body.innerHTML = originalContents;
                            }
                        </script>
                        <div class="card-body" id="printArea">

                            {{-- ✅ Alerts --}}
                            @if (session('success'))
                                <div class="alert alert-success text-center">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger text-center">{{ session('error') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- ✅ Form --}}

                            <div class="row mb-3 g-3">
                                <div class="col-12 col-md-12">
                                    <h4 class="text-center mb-4">
                                        @if (App::isLocale('en'))
                                            PERFORMANCE REVIEW REPORT
                                        @else
                                            تقرير مراجعة الأداء
                                        @endif
                                    </h4>
                                    @if (App::isLocale('en'))
                                        <h5>A- Personal Details :</h5>
                                    @else
                                        <h5> أ- البيانات الشخصية :</h5>
                                    @endif
                                    <table style="width: 100%" class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <th>Employee Name</th>
                                                    <th>Employee Number </th>
                                                    <th>Grade</th>
                                                @else
                                                    <th>اسم الموظف</th>
                                                    <th>رقم الموظف</th>
                                                    <th>المرتبة</th>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <td>{{ $result->user->name_en }}</td>
                                                    <td>{{ $result->user->phone }}</td>
                                                    <td>{{ $result->user->position->grade->name }}</td>
                                                @else
                                                    <td>{{ $result->user->name_ar }}</td>
                                                    <td>{{ $result->user->phone }}</td>
                                                    <td>{{ $result->user->position->grade->name }}</td>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <th>Department</th>
                                                    <th>Date of Hire </th>
                                                    <th>Job Title</th>
                                                @else
                                                    <th>الإدارة</th>
                                                    <th>تاريخ التوظيف </th>
                                                    <th>مسمي الوظيفة</th>
                                                @endif
                                            </tr>

                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <td>{{ $result->user->department_user->first()->unit->name }}</td>
                                                    <td>{{ $result->user->join_date }}</td>
                                                    <td>{{ $result->user->position->name }}</td>
                                                @else
                                                    <td>{{ $result->user->department_user->first()->unit->name }}</td>
                                                    <td>{{ $result->user->join_date }}</td>
                                                    <td>{{ $result->user->position->name }}</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>






                                <div class="col-12 col-md-12">

                                    @if (App::isLocale('en'))
                                        <h5>B- Performance Review :</h5>
                                    @else
                                        <h5> ب- مراجعة الأداء :</h5>
                                    @endif


                                    <table style="width: 100%" class="table table-bordered table-striped">
                                        <tbody>





                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <td> Review Duration: from &nbsp;&nbsp;&nbsp;&nbsp;
                                                        /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To &nbsp;&nbsp;&nbsp;&nbsp;
                                                        /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                @else
                                                    <td> فترة المراجعة : من&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;إلي&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>







                                {{-- User --}}
                                <div class="col-12 col-md-12">




                                    @if (App::isLocale('en'))
                                        <h5>C- Performance Factors :</h5>
                                    @else
                                        <h5> ج- عوامل الأداء :</h5>
                                    @endif

                                    @if (App::isLocale('en'))
                                        <p>Please indicate the appropriate rating that reflecting the actual employee’s
                                            performance for first (9) areas for all employees, and for all Section Heads and
                                            Managers the evaluation should be completed for all (12) areas.<br>
                                            Examples must be cited to support highest and lowest performance levels.
                                        </p>
                                    @else
                                        <p>يرجى تحديد التقدير الملائم الذي يعكس مستوى الأداء الفعلي للموظف للنقاط ال
                                            (9) الأولى لجميع الموظفين، أما بالنسبة لرؤساء الأقسام ومدراء الإدارات يجب
                                            اكمال التقييم بتحديد التقدير لجميع النقاط وعددها (12).
                                            <br>
                                            يجب ذكر أمثلة مؤيدة لأعلي وأدني مستوى أداء.
                                        </p>
                                    @endif



                                    <table style="width: 100%" class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <th>Performance Rating and Factors Definitions</th>
                                                    <th>Excellent<br><small>Significantly Exceeded Job
                                                            Requirement</small></th>
                                                    <th>Very Good<br><small>Exceeded Job Requirement</small></th>
                                                    <th>Good<br><small>Meeting Job Requirement</small></th>
                                                    <th>Fair<br><small>Needs Development to Meet Job Requirement</small>
                                                    </th>
                                                    <th>Poor<br><small>No Meeting Job Requirement</small></th>
                                                @else
                                                    <th>تعريف التقويم وعوامل الأداء</th>
                                                    <th>ممتاز<br><small>يفوق متطلبات العمل بشكل ملحوظ</small></th>
                                                    <th>جيد جداً<br><small>يفوق متطلبات العمل</small></th>
                                                    <th>جيد<br><small>يلبي متطلبات العمل</small></th>
                                                    <th>مقبول<br><small>يحتاج إلى تطوير لتلبية متطلبات العمل</small>
                                                    </th>
                                                    <th>ضعيف<br><small>لا يلبي متطلبات العمل</small></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <td><strong>Score</strong></td>
                                                    <td>10 - 9</td>
                                                    <td>8 - 7</td>
                                                    <td>6 - 5</td>
                                                    <td>4 - 3</td>
                                                    <td>2 - 1</td>
                                                @else
                                                    <td><strong>الدرجة</strong></td>
                                                    <td>٩ - ١٠</td>
                                                    <td>٧ - ٨</td>
                                                    <td>٥ - ٦</td>
                                                    <td>٣ - ٤</td>
                                                    <td>١ - ٢</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>



                                    {{-- #####################################1######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>1- Job Knowledge:</h5>
                                            <ul>
                                                <li>Having and showing proper knowledge and experience to demonstrate
                                                    job requirements.</li>
                                                <li>The ability to develop & improve job knowledge and experience in
                                                    order to perform job requirements.</li>
                                                <li>Develop & improve skills & competencies related to the job in order
                                                    to perform job.</li>
                                            </ul>
                                        @else
                                            <h5>1- معرفة العمل:</h5>
                                            <ul>
                                                <li>المعرفة و الخبرة الكافية في ممارسة الاعمال</li>
                                                <li>القدرة على تحديث و تطوير المعرفة و الخبرة الفنية بما يخدم تادية
                                                    المهام بكفاءة عالية</li>
                                                <li>تطوير المهارات القيادية و الاشرافية من خلال البرامج التدريبية و
                                                    التطوير الذاتي</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 1)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 1)->first()->score }}



                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################1######################################### --}}

                                    {{-- #####################################2######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>2- Quality and Quantity of Achieved Work:</h5>
                                            <ul>
                                                <li>Ability to maintain high job related standards and those related to
                                                    ISO 9001.</li>
                                                <li>Avoid rework and duplication of efforts.</li>
                                                <li>Continuous efforts for systematic improvements.</li>
                                            </ul>
                                        @else
                                            <h5>2- جودة وكمية العمل المنجز:</h5>
                                            <ul>
                                                <li>القدرة على المحافظة على الالتزام بالمعايير المحددة للوظيفة.</li>
                                                <li>الالتزام بالمعايير المتعلقة بنظام إدارة الجودة (ISO 9001).</li>
                                                <li>تجنب تكرار الجهود وبذل جهود دائمة لتحسين الأداء.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 2)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 2)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################2######################################### --}}

                                    {{-- #####################################3######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>3- Health, Safety & Environment (HS&E):</h5>
                                            <ul>
                                                <li>Compliance with safety & health policies, security rules.</li>
                                                <li>Observing health & environment regulations.</li>
                                                <li>Considering accident/near-miss records and proactive actions.</li>
                                            </ul>
                                        @else
                                            <h5>3- صحة وسلامة البيئة:</h5>
                                            <ul>
                                                <li>المقدرة على ادراك وفهم اجراءات السلامة العامة المتبعة في الشركة.
                                                </li>
                                                <li>الالتزام بالمعايير والأنظمة المتعلقة بالسلامة والصحة المهنية.</li>
                                                <li>تقارير مخالفات السلامة والحوادث وتقارير احتمال حدوث حادث.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 3)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 3)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################3######################################### --}}

                                    {{-- #####################################4######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>4- Dependability:</h5>
                                            <ul>
                                                <li>Degree of reliability and supervision when assuming and carrying out
                                                    work commitments and obligations.</li>
                                            </ul>
                                        @else
                                            <h5>4- الاعتمادية:</h5>
                                            <ul>
                                                <li>مدى الاعتماد وحجم الإشراف عليه في تأدية التزامات وواجبات العمل.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 4)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 4)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################4######################################### --}}

                                    {{-- #####################################5######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>5- Interpersonal Skills:</h5>
                                            <ul>
                                                <li>Ability to influence others positively and interact in a team.</li>
                                                <li>Maintaining productive relationships with supervisors, peers,
                                                    subordinates, and customers.</li>
                                            </ul>
                                        @else
                                            <h5>5- مهارات التعامل مع الآخرين:</h5>
                                            <ul>
                                                <li>القدرة على التعامل والتأثير على الآخرين بطريقة إيجابية.</li>
                                                <li>التحلي بعلاقات عمل طيبة ومثمرة مع الرؤساء والزملاء والمرؤوسين
                                                    والعملاء.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 5)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 5)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################5######################################### --}}

                                    {{-- #####################################6######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>6- Communication:</h5>
                                            <ul>
                                                <li>Ability to send and receive information effectively
                                                    verbally/written.</li>
                                                <li>Interactive understanding and respect between employee and others.
                                                </li>
                                                <li>Ability to address opinions in proper and effective way.</li>
                                                <li>Keeping colleagues and superiors informed with needed information.
                                                </li>
                                            </ul>
                                        @else
                                            <h5>6- الاتصال:</h5>
                                            <ul>
                                                <li>القدرة على إيصال واستلام وتبادل الأفكار والمعلومات خطياً وشفوياً
                                                    بكفاءة.</li>
                                                <li>التفاهم المتبادل والاحترام بين الموظف والآخرين.</li>
                                                <li>القدرة على إبداء الرأي بشكل مناسب وفعال.</li>
                                                <li>إبقاء الآخرين مطلعين على المعلومات الجديدة ومشاركتهم بها.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 6)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 6)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################6######################################### --}}

                                    {{-- #####################################7######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>7- Punctuality:</h5>
                                            <ul>
                                                <li>Displays reliability and flexibility in attendance.</li>
                                                <li>Compliance with company policy of working hours and HR records.</li>
                                            </ul>
                                        @else
                                            <h5>7- المواظبة:</h5>
                                            <ul>
                                                <li>إظهار المرونة والموثوقية في الحضور والمغادرة حسب نظام الشركة.</li>
                                                <li>التقيد بقواعد الحضور والانصراف وسجلات الموارد البشرية.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 7)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 7)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################7######################################### --}}

                                    {{-- #####################################8######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>8- Problem Solving and Decision Making:</h5>
                                            <ul>
                                                <li>Ability to identify, analyze and solve work problems.</li>
                                                <li>Assess and control risks, respond to sudden process changes, take
                                                    proper decisions.</li>
                                            </ul>
                                        @else
                                            <h5>8- حل المشاكل واتخاذ القرارات:</h5>
                                            <ul>
                                                <li>القدرة على تحديد وتحليل وحل مشاكل العمل.</li>
                                                <li>معالجة المشاكل وتقويم المخاطر والتحكم في المتغيرات المفاجئة واتخاذ
                                                    القرارات المناسبة.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 8)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 8)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################8######################################### --}}

                                    {{-- #####################################9######################################### --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>9- Innovation and Initiation:</h5>
                                            <ul>
                                                <li>Ability to conceptualize, perceive trends and urge change for
                                                    improvement.</li>
                                                <li>Ability to start/complete tasks and solve problems without relying
                                                    on others.</li>
                                            </ul>
                                        @else
                                            <h5>9- الإبداع والمبادرة:</h5>
                                            <ul>
                                                <li>القدرة على تصور وادراك عوامل غير ظاهرة والعمل على تحفيزها والتغيير
                                                    فيها بغرض التحسين.</li>
                                                <li>القدرة على البدء وإنهاء المهام وحل المشكلات دون الاعتماد على الغير.
                                                </li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 9)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 9)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################9######################################### --}}

                                    {{-- #####################################10######################################## --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>10- Leadership and Management (Managers only):</h5>
                                            <ul>
                                                <li>Ability to delegate responsibilities and supervise accordingly.</li>
                                                <li>Ability to persuade and deal fairly.</li>
                                                <li>Ability to set clear objectives aligning with company strategy.</li>
                                                <li>Ability to deliver results through teamwork and cooperation.</li>
                                            </ul>
                                        @else
                                            <h5>10- القيادة والإدارة (للمدراء فقط):</h5>
                                            <ul>
                                                <li>تفويض المهام والإشراف بموجب ذلك.</li>
                                                <li>القدرة على الإقناع والتعامل بعدل.</li>
                                                <li>القدرة على وضع أهداف واضحة تصب في استراتيجيات الشركة.</li>
                                                <li>القدرة على تحقيق نتائج مرضية من خلال التعاون والعمل الجماعي.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 10)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 10)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################10######################################## --}}

                                    {{-- #####################################11######################################## --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>11- Planning & Organizing:</h5>
                                            <ul>
                                                <li>Ability to plan, organize and set priorities to meet objectives.
                                                </li>
                                                <li>Ability to measure and assess results.</li>
                                            </ul>
                                        @else
                                            <h5>11- التخطيط والتنظيم:</h5>
                                            <ul>
                                                <li>القدرة على تخطيط وتنظيم الأعمال اليومية ووضع الأولويات لتحقيق
                                                    الأهداف.</li>
                                                <li>القدرة على قياس النتائج.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 11)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 11)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################11######################################## --}}

                                    {{-- #####################################12######################################## --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>12- Training and Development:</h5>
                                            <ul>
                                                <li>Ability to encourage growth, innovation, challenge and motivation of
                                                    subordinates.</li>
                                                <li>Ability to set measurable standards and objectives (KPIs).</li>
                                                <li>Ability to train and develop employees to perform work requirements.
                                                </li>
                                            </ul>
                                        @else
                                            <h5>12- التدريب والتطوير:</h5>
                                            <ul>
                                                <li>توفير فرص النمو، الإبداع، التحدي، وتحفيز الموظفين.</li>
                                                <li>القدرة على وضع وتطبيق معايير أداء قابلة للقياس وعادلة.</li>
                                                <li>القدرة على تدريب وتطوير الموظفين لأداء متطلبات العمل.</li>
                                            </ul>
                                        @endif
                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 12)->first()->comment }}
                                        </div>

                                        <div>
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Score:
                                                    @else
                                                        الدرجة:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->answer()->where('num', 12)->first()->score }}
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- #####################################12######################################## --}}

                                    {{-- #####################################13######################################## --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <div class="row align-items-center my-3">
                                                <div class="col-3">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Total Scores :
                                                        @else
                                                            إجمالي الدرجات:
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <span class="fw-bold fs-4">{{ $result->score }}</span>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>Total score for Section Heads and managers is sum of scores of all
                                                    12 areas of evaluation.</li>
                                                <li>Total score for non- section heads and managers is the sum of score
                                                    for only first 9 areas of evaluation multiplied by (1.33).</li>

                                            </ul>
                                        @else
                                            <div class="row align-items-center my-3">
                                                <div class="col-3">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Total Scores :
                                                        @else
                                                            إجمالي الدرجات:
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <span class="fw-bold fs-4">{{ $result->score }}</span>
                                                </div>
                                            </div>


                                            <ul>
                                                <li>لاحتساب النتيجة النهائية لكل من رؤساء الأقسام ومدراء الدوائر: حاصل
                                                    جمع علامات التقييم للنقاط ال (12) أعلاه.</li>
                                                <li>لاحتساب النتيجة النهائية للموظفين الاخرين (غير رؤساء الأقسام
                                                    ومدراء الإدارات): حاصل جمع التقييم للنقاط ال (9) الأولى فقط مضروبا
                                                    بالرقم (1.33).</li>

                                            </ul>
                                        @endif

                                    </div>
                                    <hr>
                                    {{-- #####################################13######################################## --}}
                                    @if (App::isLocale('en'))
                                        <h5>C- Performance Factors :</h5>
                                    @else
                                        <h5> هــ- تقييم الأداء العام :</h5>
                                    @endif
                                    <table style="width: 100%" class="table table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <th>Performance Rating and Factors Definitions</th>
                                                    <th>Excellent<br><small>Significantly Exceeded Job
                                                            Requirement</small></th>
                                                    <th>Very Good<br><small>Exceeded Job Requirement</small></th>
                                                    <th>Good<br><small>Meeting Job Requirement</small></th>
                                                    <th>Fair<br><small>Needs Development to Meet Job Requirement</small>
                                                    </th>
                                                    <th>Poor<br><small>No Meeting Job Requirement</small></th>
                                                @else
                                                    <th>تعريف التقويم وعوامل الأداء</th>
                                                    <th>ممتاز<br><small>يفوق متطلبات العمل بشكل ملحوظ</small></th>
                                                    <th>جيد جداً<br><small>يفوق متطلبات العمل</small></th>
                                                    <th>جيد<br><small>يلبي متطلبات العمل</small></th>
                                                    <th>مقبول<br><small>يحتاج إلى تطوير لتلبية متطلبات العمل</small>
                                                    </th>
                                                    <th>ضعيف<br><small>لا يلبي متطلبات العمل</small></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if (App::isLocale('en'))
                                                    <td><strong>Score</strong></td>
                                                    <td>108 - 120</td>
                                                    <td>84 - 107</td>
                                                    <td>60 - 83</td>
                                                    <td>36 - 59</td>
                                                    <td>12 - 35</td>
                                                @else
                                                    <td><strong>الدرجة</strong></td>
                                                    <td>108 - 120</td>
                                                    <td>84 - 107</td>
                                                    <td>60 - 83</td>
                                                    <td>36 - 59</td>
                                                    <td>12 - 35</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>




                                    {{-- #####################################13######################################## --}}
                                    <div class="mt-3">


                                        <div class="row align-items-center my-3">

                                            <h5 class="mb-0">
                                                <center>
                                                    @if (App::isLocale('en'))
                                                        If the evaluation is “ Excellent”, it is required to explain
                                                        the employee unusual performance
                                                    @else
                                                        في حال كان تقدير الأداء " ممتاز " يتطلب ذكر إنجازات الموظف
                                                        خلال كامل العام
                                                    @endif
                                                </center>

                                            </h5>


                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">
                                                <strong>
                                                    @if (App::isLocale('en'))
                                                        Comments:
                                                    @else
                                                        التعليق:
                                                    @endif
                                                </strong>
                                            </label>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->comment }}
                                        </div>


                                    </div>

                                    {{-- #####################################13######################################## --}}

                                    <div class="col-12 col-md-12">

                                        <table style="width: 100%" class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    @if (App::isLocale('en'))
                                                        <th style="width: 50%">Evaluator’s Recommendation</th>
                                                        <th style="width: 50%">Evaluator’s Signature </th>
                                                    @else
                                                        <th style="width: 50%">توصية الرئيس المباشر</th>
                                                        <th style="width: 50%">توقيع الرئيس المباشر</th>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    <td>
                                                        @if (!is_null($result->comment2))
                                                            &nbsp; {{ $result->comment2 }}
                                                        @else
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                        @endif
                                                    </td>
                                                    @if (App::isLocale('en'))
                                                        <td>Name :
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br><br>
                                                            Date :
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <br>

                                                        </td>
                                                    @else
                                                        <td>الاسـم :
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br><br>
                                                            التاريخ :
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <br>

                                                        </td>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    @if (App::isLocale('en'))
                                                        <th>Approval’s Recomendation</th>
                                                        <th>Approval’s Signature </th>
                                                    @else
                                                        <th>توصية معتمد التقرير </th>
                                                        <th>توقيع معتمد التقرير </th>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    <td>
                                                        @if (!is_null($result->comment3))
                                                            &nbsp; {{ $result->comment3 }}
                                                        @else
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br>
                                                        @endif
                                                    </td>

                                                    @if (App::isLocale('en'))
                                                        <td>Name :
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br><br>
                                                            Date :
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <br>

                                                        </td>
                                                    @else
                                                        <td>الاسـم :
                                                            ــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــــ
                                                            <br><br>
                                                            التاريخ :
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20&nbsp;&nbsp;&nbsp;&nbsp;

                                                            <br>

                                                        </td>
                                                    @endif
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>




                                    {{-- #####################################13######################################## --}}
                                    <div class="mt-3">
                                        @if (App::isLocale('en'))
                                            <h5>D- employee comment :</h5>
                                        @else
                                            <h5> و – تعليق الموظف :</h5>
                                        @endif
                                        @if (App::isLocale('en'))
                                            <div class="row align-items-center my-3">
                                                <div class="col-3">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Employee’s Signature :
                                                        @else
                                                            توقيع الموظف:
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Date :
                                                        @else
                                                            التاريخ:
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        @else
                                            <div class="row align-items-center my-3">
                                                <div class="col-3">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Employee’s Signature :
                                                        @else
                                                            توقيع الموظف:
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <h5 class="mb-0">
                                                        @if (App::isLocale('en'))
                                                            Date :
                                                        @else
                                                            التاريخ:
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>


                                        @endif

                                    </div>
                                    <br>
                                    <br>
                                    {{-- #####################################13######################################## --}}









                                </div>








                                <style>
                                    @media print {
                                        .no-print {
                                            display: none !important;
                                        }
                                    }
                                </style>


                            </div>
                        </div>
                        <div class="mb-3 ms-3">
                            <button class="btn btn-primary" onclick="printCard()">🖨️ طباعة</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

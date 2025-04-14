<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        return view('bonus');
    }

    public function showPaper()
    {
        // 論文データの配列 (10個)
        $papers = [
            // 1. メンタルヘルスと運動の関係
            [
                'title' => 'WHAT IS THE MOST EFFECTIVE EXERCISE FOR MENTAL HEALTH? FINDINGS FROM A COMPREHENSIVE META-ANALYSIS',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/39696764/',
                'content' => [
                    'title' => 'EXERCISE AND MENTAL HEALTH: EVIDENCE SUMMARY',
                    'key_evidence' => 'META-ANALYSIS OF 218 RCTS WITH 16,000+ PARTICIPANTS',
                    'findings' => [
                        'WALKING AND JOGGING: MOST EFFECTIVE EXERCISE FORMS (SUPERIOR TO CBT AND ANTIDEPRESSANTS)',
                        'DEPRESSION RISK: 30-50% LOWER IN PHYSICALLY ACTIVE PEOPLE',
                        'MINIMAL EFFECTIVE DOSE: 20 MINUTES OF LIGHT DAILY EXERCISE',
                        'COMBINATION APPROACHES: "EXERCISE + SSRIS" OR "AEROBIC + STRENGTH TRAINING" SHOW SUPERIOR OUTCOMES'
                    ],
                    'quality_matters' => [
                        'SOCIAL CONNECTION AND ENJOYMENT: MORE IMPORTANT THAN MOVEMENT ALONE',
                        'SPORTS ACTIVITIES MORE BENEFICIAL THAN EQUIVALENT PHYSICAL LABOR'
                    ],
                    'source' => 'REVIEW PAPER FROM THE AMERICAN COLLEGE OF SPORTS MEDICINE'
                ],
                'bg_class' => 'bg-blue-100',
                'text_class' => 'text-blue-900'
            ],

            // 2. 体重とモチベーションの関係
            [
                'title' => 'WEIGHT GAIN REDUCES MOTIVATION TO MOVE DUE TO DECREASED DOPAMINE D2 RECEPTORS (D2RS) IN THE BRAIN',
                'content' => [
                    'main_finding' => 'PHYSICAL INACTIVITY IS A RESULT OF OBESITY, NOT ITS CAUSE (LACK OF EXERCISE DOESN\'T DIRECTLY LEAD TO WEIGHT GAIN).',
                    'core_findings' => [
                        'HIGH-FAT DIET MICE: MOVED SLOWER, RAN LESS, AND SHOWED 30% FEWER D2RS IN THE STRIATUM (BRAIN REGION CONTROLLING MOVEMENT).',
                        'NORMAL DIET MICE: STAYED ACTIVE AND HAD NORMAL D2R LEVELS.',
                        'REDUCED D2RS DISRUPT THE BRAIN\'S "MOTIVATION CIRCUIT," MAKING MOVEMENT FEEL EFFORTFUL.',
                        'RESTORING D2RS NORMALIZED ACTIVITY IN OBESE MICE, EVEN THOUGH THEIR WEIGHT REMAINED UNCHANGED.',
                        'MICE WITH LOW D2RS WERE NOT MORE PRONE TO WEIGHT GAIN—CHALLENGING THE IDEA THAT LAZINESS CAUSES OBESITY.'
                    ],
                    'practical_applications' => [
                        'WHEN YOU FEEL LAZY: VISUALIZE AN "AGED, UNHEALTHY VERSION OF YOURSELF" TO REIGNITE MOTIVATION (PROVEN IN GYM STUDIES).',
                        'BUILD HABITS: START SMALL (E.G., 5-MINUTE DAILY STRETCHES).',
                        'ATTACH EXERCISE TO EXISTING HABITS ("TOOTHBRUSHING SQUATS").',
                    ],
                    'study_info' => [
                        'JOURNAL: CELL METABOLISM (TOP-TIER METABOLISM RESEARCH).',
                        'INSTITUTION: U.S. NATIONAL INSTITUTES OF HEALTH (NIH), A GLOBAL LEADER IN BIOMEDICAL SCIENCE.',
                    ],
                    'takeaway' => 'OBESITY ALTERS BRAIN CHEMISTRY, MAKING MOVEMENT FEEL HARDER—BUT SMALL, CONSISTENT HABITS CAN COUNTERACT THIS. BLAME BIOLOGY, NOT WILLPOWER!'
                ],
                'bg_class' => 'bg-gray-100',
                'text_class' => 'text-gray-900'
            ],

            // 3. 睡眠と認知機能の関係
            [
                'title' => '7-8 HOURS OF SLEEP IS THE SWEET SPOT!',
                'content' => [
                    'conclusion' => 'TOO SHORT OR TOO LONG SLEEP HARMS THINKING SKILLS (REASONING, PROBLEM-SOLVING, LANGUAGE)',
                    'key_findings' => [
                        '100,000+ ADULTS\' SLEEP BRAINPOWER DATA ANALYZED',
                        '7-8 HOURS = PEAK BRAINPOWER',
                        '4-HOUR SLEEP = COGNITIVE ABILITIES EQUIVALENT TO AGING 8 YEARS!',
                        '9+ HOURS = PEAK PERFORMANCE DROPS (EVEN IN HEALTHY PEOPLE)'
                    ],
                    'affected_abilities' => [
                        'REASONING, LANGUAGE: PLUMMETS WITH POOR SLEEP',
                        'SHORT-TERM MEMORY: RESISTS SLEEP CHANGES',
                        'POWER OF "ONE GOOD NIGHT": EVEN CHRONIC SLEEP-DEPRIVED PEOPLE REGAIN FOCUS AFTER A FULL 7-8 HOURS!'
                    ],
                    'real_life_tips' => [
                        'FOR BIG DAYS (MEETINGS, EXAMS): PRIORITIZE 7-8 HOURS OF SLEEP THE NIGHT BEFORE',
                        'DAILY HABIT: AIM FOR ~7 HOURS TO KEEP YOUR BRAIN SHARP'
                    ],
                    'study_info' => [
                        'JOURNAL: SLEEP (WORLD-LEADING SLEEP SCIENCE JOURNAL)',
                        'DATA: 10,000+ PARTICIPANTS = STRONG EVIDENCE'
                    ],
                    'final_takeaway' => 'SLEEP IS LIKE A BRAIN RECHARGE: TOO LITTLE OR TOO MUCH = BLURRY THINKING. 7-8 HOURS = GOLD STANDARD FOR MENTAL CLARITY!'
                ],
                'bg_class' => 'bg-green-100',
                'text_class' => 'text-green-900'
            ],

            // 4. 水分摂取と認知機能
            [
                'title' => 'HYDRATION AND COGNITIVE PERFORMANCE: EVEN MILD DEHYDRATION IMPAIRS BRAIN FUNCTION',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/30499741/',
                'content' => [
                    'title' => 'HYDRATION AND BRAIN FUNCTION: LATEST FINDINGS',
                    'key_evidence' => 'META-ANALYSIS OF 33 STUDIES WITH 3,300+ PARTICIPANTS',
                    'findings' => [
                        'JUST 1-2% BODY WATER LOSS IMPAIRS ATTENTION, COORDINATION, AND EXECUTIVE FUNCTION',
                        'WOMEN MORE SENSITIVE TO DEHYDRATION EFFECTS THAN MEN',
                        'COGNITIVE DECLINE STARTS BEFORE THIRST SENSATION APPEARS',
                        'OLDER ADULTS AT HIGHER RISK DUE TO BLUNTED THIRST RESPONSE'
                    ],
                    'practical_applications' => [
                        'MORNING ROUTINE: START DAY WITH 16-20OZ (500-600ML) WATER BEFORE BREAKFAST',
                        'COGNITIVE TEST: IF URINE IS DARK YELLOW, YOU\'RE ALREADY DEHYDRATED',
                        'OFFICE TIP: KEEP WATER BOTTLE VISIBLE ON DESK AS REMINDER',
                        'EXERCISE RECOVERY: COGNITIVE BENEFITS DIMINISH WITHOUT PROPER REHYDRATION'
                    ],
                    'source' => 'BRITISH JOURNAL OF NUTRITION'
                ],
                'bg_class' => 'bg-blue-100',
                'text_class' => 'text-blue-900'
            ],

            // 5. 朝食と認知パフォーマンス
            [
                'title' => 'BREAKFAST QUALITY IMPACTS COGNITIVE PERFORMANCE THROUGHOUT THE DAY',
                'content' => [
                    'main_finding' => 'SKIPPING BREAKFAST OR CHOOSING HIGH-SUGAR OPTIONS SIGNIFICANTLY REDUCES COGNITIVE PERFORMANCE.',
                    'core_findings' => [
                        'BREAKFAST SKIPPERS SHOWED 8-10% LOWER ATTENTION SCORES VS. BREAKFAST EATERS',
                        'HIGH-PROTEIN BREAKFASTS SUSTAINED ATTENTION AND REDUCED MENTAL FATIGUE FOR 4-5 HOURS',
                        'HIGH-SUGAR BREAKFASTS CAUSED INITIAL ENERGY SPIKE FOLLOWED BY PERFORMANCE CRASH WITHIN 2 HOURS',
                        'CHILDREN WHO ATE BREAKFAST SCORED 17.5% HIGHER ON STANDARDIZED TESTS'
                    ],
                    'optimal_breakfast' => [
                        'PROTEIN: 20-30G (EGGS, GREEK YOGURT, PROTEIN SMOOTHIE)',
                        'COMPLEX CARBS: OATS, WHOLE GRAIN BREAD, FRUITS WITH SKIN',
                        'HEALTHY FATS: AVOCADO, NUTS, SEEDS FOR SUSTAINED ENERGY',
                        'TIMING: IDEALLY WITHIN 1 HOUR OF WAKING'
                    ],
                    'study_info' => [
                        'JOURNAL: AMERICAN JOURNAL OF CLINICAL NUTRITION',
                        'RESEARCH TYPE: RANDOMIZED CONTROLLED TRIALS IN ADULTS AND CHILDREN'
                    ],
                    'takeaway' => 'BREAKFAST FUELS YOUR BRAIN! CHOOSE PROTEIN, FIBER, AND HEALTHY FATS FOR ALL-DAY COGNITIVE PERFORMANCE.'
                ],
                'bg_class' => 'bg-yellow-100',
                'text_class' => 'text-yellow-900'
            ],

            // 6. 瞑想と脳の健康
            [
                'title' => 'MEDITATION PHYSICALLY CHANGES YOUR BRAIN IN 8 WEEKS',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/30153464/',
                'content' => [
                    'title' => 'MEDITATION AND NEUROPLASTICITY: EVIDENCE SUMMARY',
                    'key_evidence' => 'HARVARD-LED BRAIN IMAGING STUDY WITH FIRST-TIME MEDITATORS',
                    'findings' => [
                        'JUST 8 WEEKS OF DAILY MEDITATION (20 MINUTES) VISIBLY INCREASED GRAY MATTER IN KEY BRAIN REGIONS',
                        'HIPPOCAMPUS (MEMORY CENTER): SHOWED 5-10% INCREASED DENSITY',
                        'AMYGDALA (FEAR CENTER): DECREASED ACTIVITY AND SIZE',
                        'PREFRONTAL CORTEX (DECISION-MAKING): ENHANCED CONNECTIVITY AND FUNCTION'
                    ],
                    'practical_benefits' => [
                        'STRESS RESILIENCE: 32% REDUCTION IN STRESS HORMONE CORTISOL',
                        'FOCUS IMPROVEMENT: 16% BETTER SUSTAINED ATTENTION SCORES',
                        'CELLULAR AGING: SLOWED CELLULAR AGING BY PROTECTING TELOMERES',
                        'IMMUNE FUNCTION: 7X STRONGER ANTIBODY RESPONSE TO FLU VACCINE IN MEDITATORS'
                    ],
                    'beginner_tips' => [
                        'START WITH 5 MINUTES DAILY AND GRADUALLY INCREASE',
                        'TRY GUIDED APPS (HEADSPACE, CALM, INSIGHT TIMER)',
                        'CONSISTENCY MATTERS MORE THAN DURATION',
                        'MINDFUL MOMENTS ANYWHERE: WAITING IN LINE, EATING, WALKING'
                    ],
                    'source' => 'PUBLISHED IN NEUROIMAGE (LEADING NEUROIMAGING JOURNAL)'
                ],
                'bg_class' => 'bg-indigo-100',
                'text_class' => 'text-indigo-900'
            ],

            // 7. 腸内細菌と精神的健康
            [
                'title' => 'THE GUT-BRAIN CONNECTION: HOW YOUR MICROBIOME AFFECTS MENTAL HEALTH',
                'content' => [
                    'main_finding' => 'YOUR GUT BACTERIA DIRECTLY INFLUENCE BRAIN CHEMISTRY, MOOD, AND MENTAL HEALTH.',
                    'core_findings' => [
                        '90% OF SEROTONIN (HAPPINESS NEUROTRANSMITTER) IS PRODUCED IN THE GUT',
                        'DEPRESSED PATIENTS SHOW DISTINCTLY DIFFERENT GUT BACTERIA THAN HEALTHY CONTROLS',
                        'MOUSE STUDIES: TRANSFERRING GUT BACTERIA FROM ANXIOUS MICE TO CALM MICE MADE THE CALM MICE ANXIOUS',
                        'PROBIOTICS REDUCED SYMPTOMS IN PATIENTS WITH ANXIETY AND DEPRESSION BY 40-50% IN SOME STUDIES'
                    ],
                    'microbiome_boosters' => [
                        'PREBIOTICS: FEED GOOD BACTERIA WITH FIBER FROM VEGETABLES, FRUITS, LEGUMES',
                        'PROBIOTICS: FERMENTED FOODS LIKE YOGURT, KIMCHI, SAUERKRAUT, KEFIR',
                        'DIVERSITY: AIM FOR 30+ DIFFERENT PLANT FOODS WEEKLY',
                        'LIMIT: ARTIFICIAL SWEETENERS, PROCESSED FOODS, EXCESSIVE ALCOHOL'
                    ],
                    'study_info' => [
                        'EMERGING FIELD: PSYCHOBIOTICS (USING PROBIOTICS FOR MENTAL HEALTH)',
                        'INSTITUTIONS: HARVARD, OXFORD, AND UC SAN DIEGO MICROBIOME CENTERS'
                    ],
                    'takeaway' => 'YOUR DIET LITERALLY FEEDS YOUR MOOD. A DIVERSE, PLANT-RICH DIET SUPPORTS BOTH GUT AND MENTAL HEALTH.'
                ],
                'bg_class' => 'bg-pink-100',
                'text_class' => 'text-pink-900'
            ],

            // 8. 自然との接触と健康
            [
                'title' => 'NATURE EXPOSURE: THE 20-MINUTE PRESCRIPTION FOR STRESS REDUCTION',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/33809353/',
                'content' => [
                    'title' => 'NATURE AND HEALTH: DOSE-RESPONSE RELATIONSHIP',
                    'key_evidence' => 'STUDY ACROSS 4 CONTINENTS WITH 33,000 PARTICIPANTS',
                    'findings' => [
                        'JUST 20-30 MINUTES IN NATURE SIGNIFICANTLY LOWERS CORTISOL (STRESS HORMONE)',
                        'OPTIMAL "DOSE": 120 MINUTES/WEEK OF NATURE EXPOSURE FOR MAXIMUM WELLBEING',
                        'FOREST ENVIRONMENTS OUTPERFORMED URBAN GREEN SPACES FOR STRESS REDUCTION',
                        'BENEFITS HELD REGARDLESS OF AGE, GENDER, OR CULTURAL BACKGROUND'
                    ],
                    'physiological_effects' => [
                        'BLOOD PRESSURE: AVERAGE DROP OF 9-10 POINTS AFTER 30 MINUTES IN FOREST ENVIRONMENT',
                        'IMMUNE FUNCTION: 50% INCREASE IN NATURAL KILLER CELLS AFTER 3 DAYS OF FOREST EXPOSURE',
                        'BRAIN ACTIVITY: CALMING OF PREFRONTAL CORTEX AND REDUCED RUMINATION',
                        'ATTENTION: 20% IMPROVEMENT ON COGNITIVE TESTS AFTER NATURE WALK VS. URBAN WALK'
                    ],
                    'implementation_tips' => [
                        'LUNCH BREAK: EAT OUTDOORS OR TAKE A 10-MINUTE WALK IN NEARBY GREEN SPACE',
                        'WEEKENDS: SCHEDULE "GREEN TIME" LIKE YOU WOULD ANY IMPORTANT APPOINTMENT',
                        'INDOOR OPTION: EVEN VIEWING NATURE PHOTOS OR HAVING PLANTS INDOORS PROVIDES SMALL BENEFITS',
                        'QUALITY MATTERS: WILDER, MORE BIODIVERSE ENVIRONMENTS OFFER STRONGER EFFECTS'
                    ],
                    'source' => 'FRONTIERS IN PSYCHOLOGY, NATURE SCIENTIFIC REPORTS'
                ],
                'bg_class' => 'bg-green-100',
                'text_class' => 'text-green-900'
            ],

            // 9. 社会的接触と寿命
            [
                'title' => 'SOCIAL CONNECTIONS: AS IMPORTANT TO HEALTH AS DIET AND EXERCISE',
                'content' => [
                    'main_finding' => 'STRONG SOCIAL TIES INCREASE LONGEVITY BY 50%, EQUIVALENT TO QUITTING SMOKING.',
                    'core_findings' => [
                        'META-ANALYSIS OF 148 STUDIES (308,000 PARTICIPANTS) LINKED STRONG RELATIONSHIPS TO 50% INCREASED SURVIVAL',
                        'SOCIAL ISOLATION INCREASES MORTALITY RISK MORE THAN OBESITY OR PHYSICAL INACTIVITY',
                        'QUALITY OVER QUANTITY: DEPTH OF CONNECTIONS MATTERS MORE THAN NUMBER OF CONTACTS',
                        'HEALTH IMPACTS: CARDIOVASCULAR, IMMUNE, AND BRAIN HEALTH ALL IMPROVED WITH SOCIAL CONNECTION'
                    ],
                    'biological_mechanisms' => [
                        'INFLAMMATORY MARKERS: SOCIALLY CONNECTED PEOPLE SHOW 20% LOWER LEVELS OF INFLAMMATORY PROTEINS',
                        'TELOMERE LENGTH: SOCIAL SUPPORT PRESERVES THESE "AGING CLOCKS" IN CELLS',
                        'VAGAL TONE: IMPROVED HEART-BRAIN CONNECTION IN PEOPLE WITH SUPPORTIVE RELATIONSHIPS',
                        'GENE EXPRESSION: 209 GENES REGULATED DIFFERENTLY IN SOCIALLY ISOLATED VS. CONNECTED PEOPLE'
                    ],
                    'practical_steps' => [
                        'PRIORITIZE: SCHEDULE SOCIAL TIME LIKE ANY HEALTH ACTIVITY',
                        'QUALITY TIME: DEVICE-FREE, FACE-TO-FACE INTERACTION WHENEVER POSSIBLE',
                        'VOLUNTEERING: HELPS OTHERS WHILE BUILDING YOUR OWN SOCIAL NETWORK',
                        'SMALL STEPS: EVEN BRIEF, GENUINE INTERACTIONS WITH STRANGERS PROVIDE BENEFITS'
                    ],
                    'study_info' => [
                        'INSTITUTIONS: HARVARD, BRIGHAM YOUNG UNIVERSITY, UNIVERSITY OF CHICAGO',
                        'JOURNALS: PLOS MEDICINE, PROCEEDINGS OF THE NATIONAL ACADEMY OF SCIENCES'
                    ],
                    'takeaway' => 'YOUR SOCIAL CONNECTIONS ARE A CRITICAL PART OF YOUR HEALTH REGIMEN, NOT JUST A LUXURY.'
                ],
                'bg_class' => 'bg-orange-100',
                'text_class' => 'text-orange-900'
            ],

            // 10. 間欠的断食の健康効果
            [
                'title' => 'INTERMITTENT FASTING: CELLULAR REJUVENATION BEYOND WEIGHT LOSS',
                'url' => 'https://pubmed.ncbi.nlm.nih.gov/31881139/',
                'content' => [
                    'title' => 'INTERMITTENT FASTING: CELLULAR AND METABOLIC EFFECTS',
                    'key_evidence' => 'SYSTEMATIC REVIEW OF 40+ HUMAN CLINICAL TRIALS',
                    'findings' => [
                        'AUTOPHAGY (CELLULAR CLEANING) ACTIVATED AFTER 12-16 HOURS WITHOUT FOOD',
                        'BRAIN-DERIVED NEUROTROPHIC FACTOR (BDNF) INCREASES 50-400% DURING FASTING (PROTECTS BRAIN CELLS)',
                        'INSULIN SENSITIVITY IMPROVED EVEN WITHOUT WEIGHT LOSS',
                        'INFLAMMATION MARKERS DECREASED BY 20-30% AFTER 1 MONTH OF 16:8 FASTING'
                    ],
                    'fasting_approaches' => [
                        'TIME-RESTRICTED EATING (16:8): EAT WITHIN 8-HOUR WINDOW, FAST 16 HOURS',
                        '5:2 METHOD: NORMAL EATING 5 DAYS, RESTRICTED CALORIES (500-600) 2 NON-CONSECUTIVE DAYS',
                        'ALTERNATE-DAY FASTING: ALTERNATE BETWEEN REGULAR EATING AND VERY LOW CALORIE DAYS',
                        'CIRCADIAN RHYTHM FASTING: LIMIT EATING TO DAYLIGHT HOURS ONLY'
                    ],
                    'beyond_weight_loss' => [
                        'COGNITIVE FUNCTION: IMPROVED MEMORY, FOCUS, AND MENTAL CLARITY',
                        'CELLULAR STRESS RESISTANCE: ENHANCES ABILITY TO WITHSTAND DAMAGE',
                        'LONGEVITY PATHWAYS: ACTIVATES SAME MECHANISMS AS CALORIC RESTRICTION',
                        'METABOLIC FLEXIBILITY: IMPROVES BODY\'S ABILITY TO SWITCH BETWEEN FUEL SOURCES'
                    ],
                    'source' => 'NEW ENGLAND JOURNAL OF MEDICINE, CELL METABOLISM'
                ],
                'bg_class' => 'bg-purple-100',
                'text_class' => 'text-purple-900'
            ]
        ];

        // ランダムに1つを選択
        $randomPaper = $papers[array_rand($papers)];

        return view('paper', ['paper' => $randomPaper]);
    }
}
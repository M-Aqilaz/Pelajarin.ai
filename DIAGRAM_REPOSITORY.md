# Dokumentasi Use Case, Activity, dan Class Diagram Pelajarin.ai

Dokumen ini dibuat berdasarkan hasil scan struktur repository Laravel `Pelajarin.ai`, terutama dari direktori `routes`, `app`, `database`, `resources`, `config`, dan `tests`.

## 1. Ringkasan Repository

Pelajarin.ai adalah aplikasi pembelajaran berbasis Laravel 13 dengan Blade, Tailwind CSS, Vite, Alpine.js, Queue, dan Laravel Reverb. Sistem menyediakan upload materi belajar, ringkasan AI, tutor chat AI, flashcard, kuis, pomodoro/focus planner, study room realtime, study matching, notification center, social login, dan panel admin.

### Struktur Direktori Utama

```text
app/
  Contracts/              Kontrak service AI
  Data/                   DTO hasil AI
  Events/                 Event broadcast realtime
  Http/
    Controllers/          Controller publik, user, learning, auth, admin
    Middleware/           Middleware admin dan limit room
    Requests/             Form request profil dan auth
  Jobs/                   Job queue untuk balasan AI
  Models/                 Model Eloquent domain aplikasi
  Notifications/          Notifikasi database untuk chat/AI/room/match
  Providers/              Service provider aplikasi
  Services/
    Ai/                   Integrasi AI chat
    Learning/             Extractor materi, generator konten, matching, scheduler
  Support/                Helper limiter, payload realtime, typing state
bootstrap/                Bootstrap Laravel
config/                   Konfigurasi app, auth, broadcasting, queue, reverb, services
database/
  factories/              Factory testing
  migrations/             Skema tabel domain
  seeders/                Seeder demo/tester
public/                   Entry public, image logo, build Vite
resources/
  css/                    Tailwind/app CSS
  js/                     Alpine, realtime chat, pomodoro, planner
  views/                  Blade pages, layouts, components, auth, error
routes/                   Route web, auth, broadcast channel, console
tests/                    Feature dan unit tests
```

## 2. Modul dan File Penting

| Modul | File Utama | Tanggung Jawab |
| --- | --- | --- |
| Public | `routes/web.php`, `PricingController`, `pages/public/*` | Landing page, pricing, tracking klik fitur |
| Auth | `routes/auth.php`, `Http/Controllers/Auth/*`, `LoginRequest` | Register, login, logout, reset password, verification, social login Google/Discord |
| Dashboard | `routes/web.php`, `pages/user/dashboard.blade.php` | Ringkasan jumlah materi, summary, thread, room, match |
| Material | `MaterialController`, `MaterialTextExtractor`, `AiMaterialCleaner`, `Material` | Upload file/teks, ekstraksi teks, OCR, pembersihan AI, summary awal |
| Summary | `SummaryController`, `AiSummary` | Daftar dan detail ringkasan AI |
| AI Chat | `ChatThreadController`, `ChatMessageController`, `GenerateThreadAiReply`, `OpenAiThreadResponder` | Thread tutor AI, pesan, queue balasan, broadcast status |
| Flashcard | `FlashcardController`, `StudyContentGenerator`, `FlashcardReviewScheduler` | Generate deck/cards, spaced repetition review |
| Quiz | `QuizController`, `StudyContentGenerator`, `QuizSet`, `QuizQuestion` | Generate soal, sesi jawab via session, hasil kuis |
| Focus Tools | `resources/js/app.js`, `pomodoro.blade.php`, `focus/*` | Pomodoro, focus planner, focus insights berbasis localStorage |
| Study Room | `StudyRoomController`, `StudyRoomMessageController`, events room | Room publik/private, member, realtime chat, typing |
| Study Matching | `StudyMatchingController`, `StudyMatchingService`, matching models | Profil belajar, antrean, roulette, chat match, block/report |
| Notification | `NotificationController`, `Notifications/*` | Daftar notifikasi dan mark read |
| Admin | `AdminController`, `AdminUserController`, `AdminDocumentController` | Monitoring AI, statistik, user management, dokumen |
| Realtime | `routes/channels.php`, `Events/*`, `resources/js/realtime-chat.js` | Private channels `thread`, `room`, `match`, payload broadcast |

## 3. Use Case Diagram

### Aktor

| Aktor | Deskripsi |
| --- | --- |
| Guest | Pengunjung belum login. Bisa melihat landing/pricing, register, login, social login, reset password. |
| User | Pengguna login. Bisa memakai fitur belajar, social learning, focus tools, profil, dan notifikasi. |
| Premium User | User dengan `plan = premium`. Mendapat limit lebih besar untuk OCR, AI, room, dan matching. |
| Admin | User dengan role admin. Bisa mengelola user, dokumen, statistik, dan monitoring AI. |
| AI Provider | OpenAI/OpenRouter-compatible API untuk ringkasan, pembersihan materi, flashcard, kuis, chat tutor. |
| OCR Tools | Binary lokal seperti `pdftotext`, `pdftoppm`, dan `tesseract` untuk ekstraksi file. |
| Realtime System | Laravel Reverb/Echo untuk broadcast message, typing, dan status AI. |

```mermaid
flowchart LR
    Guest[Guest]
    User[User]
    PremiumUser[Premium User]
    Admin[Admin]
    AI[AI Provider]
    OCR[OCR Tools]
    RT[Realtime System]

    subgraph PublicUseCases[Public Use Cases]
        UC_Landing[Melihat Landing Page]
        UC_Pricing[Melihat Pricing]
        UC_Register[Register]
        UC_Login[Login]
        UC_SocialLogin[Login Google/Discord]
        UC_ResetPassword[Reset Password]
    end

    subgraph UserUseCases[User Use Cases]
        UC_Dashboard[Melihat Dashboard]
        UC_Upload[Upload Materi]
        UC_Material[Melihat Materi]
        UC_Summary[Melihat Ringkasan]
        UC_CreateThread[Membuat Chat Thread]
        UC_AiChat[Chat Tutor AI]
        UC_GenerateFlashcard[Generate Flashcard]
        UC_ReviewFlashcard[Review Flashcard]
        UC_GenerateQuiz[Generate Quiz]
        UC_DoQuiz[Mengerjakan Quiz]
        UC_Pomodoro[Menggunakan Pomodoro]
        UC_Planner[Mengelola Focus Planner]
        UC_Insights[Melihat Focus Insights]
        UC_CreateRoom[Membuat Study Room]
        UC_JoinRoom[Join/Leave Study Room]
        UC_RoomChat[Chat Room Realtime]
        UC_MatchProfile[Mengatur Profil Matching]
        UC_SearchMatch[Cari Partner Belajar]
        UC_Roulette[Study Roulette]
        UC_MatchChat[Chat Dengan Match]
        UC_BlockReport[Block/Report Partner]
        UC_Profile[Mengelola Profil]
        UC_Notification[Membaca Notifikasi]
    end

    subgraph PremiumUseCases[Premium Use Cases]
        UC_OcrLimit[OCR Lebih Banyak Halaman]
        UC_AiLimit[Limit AI Lebih Besar]
        UC_MatchNoCredit[Matching Tanpa Kredit Gratis]
    end

    subgraph AdminUseCases[Admin Use Cases]
        UC_AdminDashboard[Melihat Admin Dashboard]
        UC_MonitoringAi[Monitoring AI]
        UC_Stats[Statistik Pembelajaran]
        UC_UserStatus[Suspend/Aktivasi User]
        UC_Documents[Kelola Dokumen]
    end

    Guest --> UC_Landing
    Guest --> UC_Pricing
    Guest --> UC_Register
    Guest --> UC_Login
    Guest --> UC_SocialLogin
    Guest --> UC_ResetPassword

    User --> UC_Dashboard
    User --> UC_Upload
    User --> UC_Material
    User --> UC_Summary
    User --> UC_CreateThread
    User --> UC_AiChat
    User --> UC_GenerateFlashcard
    User --> UC_ReviewFlashcard
    User --> UC_GenerateQuiz
    User --> UC_DoQuiz
    User --> UC_Pomodoro
    User --> UC_Planner
    User --> UC_Insights
    User --> UC_CreateRoom
    User --> UC_JoinRoom
    User --> UC_RoomChat
    User --> UC_MatchProfile
    User --> UC_SearchMatch
    User --> UC_Roulette
    User --> UC_MatchChat
    User --> UC_BlockReport
    User --> UC_Profile
    User --> UC_Notification

    PremiumUser --> User
    PremiumUser --> UC_OcrLimit
    PremiumUser --> UC_AiLimit
    PremiumUser --> UC_MatchNoCredit

    Admin --> User
    Admin --> UC_AdminDashboard
    Admin --> UC_MonitoringAi
    Admin --> UC_Stats
    Admin --> UC_UserStatus
    Admin --> UC_Documents

    UC_Upload -. uses .-> OCR
    UC_Upload -. clean/summarize .-> AI
    UC_AiChat -. generate reply .-> AI
    UC_GenerateFlashcard -. optional generation .-> AI
    UC_GenerateQuiz -. optional generation .-> AI
    UC_AiChat -. broadcast status/message .-> RT
    UC_RoomChat -. broadcast message/typing .-> RT
    UC_MatchChat -. broadcast message/typing .-> RT
```

## 4. Activity Diagram

### 4.1 Upload Materi dan Generate Ringkasan

Berdasarkan `MaterialController::store`, `MaterialTextExtractor`, dan `AiMaterialCleaner`.

```mermaid
flowchart TD
    A[User buka Upload Materi] --> B[Isi title dan upload file atau raw_text]
    B --> C{Validasi request}
    C -- gagal --> D[Kembali dengan error]
    C -- valid --> E{Ada file?}
    E -- ya --> F[MaterialTextExtractor ekstrak teks]
    F --> G{File perlu OCR?}
    G -- ya --> H[Jalankan OCR PDF/Image sesuai config]
    G -- tidak --> I[Gunakan teks native]
    H --> J[Normalisasi hasil teks]
    I --> J
    E -- tidak --> K[Gunakan raw_text manual]
    J --> L{Teks kosong?}
    K --> L
    L -- ya --> D
    L -- tidak --> M{File punya teks hasil ekstraksi?}
    M -- ya --> N[AiMaterialCleaner clean OCR text]
    M -- tidak --> O[Gunakan teks final]
    N --> O
    O --> P[Simpan Material status processed]
    P --> Q[AiMaterialCleaner summarize]
    Q --> R{AI summary tersedia?}
    R -- ya --> S[Simpan AiSummary dari AI]
    R -- tidak --> T[Simpan fallback summary lokal]
    S --> U[Redirect ke summaries.show]
    T --> U
```

### 4.2 Chat Tutor AI

Berdasarkan `ChatThreadController`, `ChatMessageController`, `GenerateThreadAiReply`, dan `OpenAiThreadResponder`.

```mermaid
flowchart TD
    A[User buka fitur Chat] --> B[Membuat thread atau buka thread]
    B --> C{Ada opening_message atau pesan baru?}
    C -- tidak --> D[Tampilkan thread]
    C -- ya --> E[Validasi kepemilikan thread/material]
    E --> F[AiUsageLimiter check]
    F --> G{Allowed?}
    G -- tidak --> H[Return error 429 atau back with errors]
    G -- ya --> I[Simpan ChatMessage role user]
    I --> J[AiUsageLimiter hit]
    J --> K[Set ChatThread ai_status queued]
    K --> L[Broadcast ThreadMessageCreated dan ThreadAiStatusUpdated]
    L --> M[Dispatch GenerateThreadAiReply]
    M --> N[Job load thread + material + messages]
    N --> O[Set ai_status processing dan broadcast]
    O --> P[OpenAiThreadResponder generateReply]
    P --> Q{AI sukses?}
    Q -- ya --> R[Simpan ChatMessage role assistant]
    R --> S[Set ai_status idle]
    S --> T[Broadcast reply dan status]
    T --> U[Kirim ThreadAiReplyNotification]
    Q -- gagal --> V[Set ai_status failed + ai_error]
    V --> W[Broadcast status failed]
```

### 4.3 Generate dan Review Flashcard

Berdasarkan `FlashcardController`, `StudyContentGenerator`, dan `FlashcardReviewScheduler`.

```mermaid
flowchart TD
    A[User pilih material di Flashcards] --> B[Controller load Material + FlashcardDeck.cards]
    B --> C{User klik Generate?}
    C -- tidak --> D[Tampilkan deck, due card, current card]
    C -- ya --> E[AiContentGenerationLimiter check feature flashcards]
    E --> F{Allowed?}
    F -- tidak --> G[Redirect dengan error limit]
    F -- ya --> H[StudyContentGenerator generateFlashcards]
    H --> I{AI menghasilkan >= 4 card?}
    I -- ya --> J[Gunakan flashcards AI]
    I -- tidak --> K[Fallback knowledge pairs dari raw_text]
    J --> L{Jumlah card >= 4?}
    K --> L
    L -- tidak --> M[Redirect error materi belum cukup]
    L -- ya --> N[Hit limiter]
    N --> O[UpdateOrCreate FlashcardDeck]
    O --> P[Delete card lama]
    P --> Q[CreateMany card baru]
    Q --> R[Tampilkan deck]
    R --> S{User review card?}
    S -- ya --> T[Validasi rating again/hard/good/easy]
    T --> U[FlashcardReviewScheduler apply spaced repetition]
    U --> R
```

### 4.4 Generate dan Mengerjakan Quiz

Berdasarkan `QuizController` dan `StudyContentGenerator`.

```mermaid
flowchart TD
    A[User pilih material di Quiz] --> B[Load Material + QuizSet.questions]
    B --> C{Generate Quiz?}
    C -- ya --> D[AiContentGenerationLimiter check feature quiz]
    D --> E{Allowed?}
    E -- tidak --> F[Redirect dengan error limit]
    E -- ya --> G[StudyContentGenerator generateQuiz]
    G --> H{AI menghasilkan >= 4 soal?}
    H -- ya --> I[Gunakan soal AI]
    H -- tidak --> J[Fallback soal dari knowledge pairs]
    I --> K{Jumlah soal >= 4?}
    J --> K
    K -- tidak --> L[Redirect error materi belum cukup]
    K -- ya --> M[UpdateOrCreate QuizSet]
    M --> N[Delete soal lama dan createMany soal baru]
    N --> O[Reset session attempt]
    C -- tidak --> P{Start Quiz?}
    P -- ya --> Q[Session quiz_attempts.id current_index=0]
    Q --> R[Tampilkan current question]
    R --> S[User pilih jawaban]
    S --> T[Validasi question_id dan choice]
    T --> U{Urutan soal sesuai?}
    U -- tidak --> V[Error mulai ulang]
    U -- ya --> W[Simpan answer di session]
    W --> X{Soal terakhir?}
    X -- tidak --> R
    X -- ya --> Y[Build results score dan explanation]
```

### 4.5 Study Room Realtime

Berdasarkan `StudyRoomController`, `StudyRoomMessageController`, events room, dan `routes/channels.php`.

```mermaid
flowchart TD
    A[User buka Rooms] --> B[List rooms dan myRooms]
    B --> C{Membuat room?}
    C -- ya --> D[Validasi name topic visibility max_members]
    D --> E[Create StudyRoom]
    E --> F[Create StudyRoomMember owner active]
    F --> G[Redirect rooms.show]
    C -- tidak --> H{Join room?}
    H -- ya --> I[Cek is_active dan max_members]
    I --> J[FirstOrCreate membership active]
    J --> G
    H -- tidak --> K[Show room]
    K --> L{Room private?}
    L -- ya --> M[Cek active membership]
    L -- tidak --> N[Allow access]
    M --> O{Allowed?}
    O -- tidak --> P[403]
    O -- ya --> Q[Load messages kecuali blocked users]
    N --> Q
    Q --> R[User kirim pesan]
    R --> S[Validasi active member]
    S --> T[Simpan StudyRoomMessage]
    T --> U[Broadcast RoomMessageCreated]
    U --> V[Kirim RoomMessageNotification ke member lain]
    Q --> W[User typing]
    W --> X[TypingStateStore touch]
    X --> Y[Broadcast RoomTypingUpdated]
```

### 4.6 Study Matching dan Roulette

Berdasarkan `StudyMatchingController` dan `StudyMatchingService`.

```mermaid
flowchart TD
    A[User buka Matchmaking/Roulette] --> B[Load StudyProfile dan active match]
    B --> C{Update profile?}
    C -- ya --> D[UpdateOrCreate StudyProfile]
    C -- tidak --> E{Search/Start Roulette?}
    E -- ya --> F[Cek profile matchmaking enabled]
    F --> G{Enabled?}
    G -- tidak --> H[Error aktifkan profil]
    G -- ya --> I{Free user punya match_credits?}
    I -- tidak --> J[Error kuota habis]
    I -- ya --> K[Expire old queue entries]
    K --> L{Existing waiting queue?}
    L -- ya --> M[Return queue atau active match]
    L -- tidak --> N[Cari candidate waiting topic sama / roulette]
    N --> O{Candidate ditemukan?}
    O -- ya --> P[Set candidate matched]
    P --> Q[Create StudyMatch active]
    Q --> R[Decrement match_credits untuk free users]
    R --> S[Redirect match/show atau roulette]
    O -- tidak --> T[Create MatchQueueEntry waiting expires 20 menit]
    T --> U[Tampilkan status antrean]
    B --> V{Dalam active match?}
    V -- ya --> W[Chat match realtime]
    W --> X[Simpan StudyMatchMessage]
    X --> Y[Broadcast StudyMatchMessageCreated]
    Y --> Z[Kirim StudyMatchMessageNotification ke partner]
    W --> AA{Block/Report/End?}
    AA -- Block --> AB[Create UserBlock + status cancelled]
    AA -- Report --> AC[Create UserReport status open]
    AA -- End --> AD[Set StudyMatch completed]
```

### 4.7 Focus Tools Frontend

Berdasarkan `resources/js/app.js`, `pomodoro.blade.php`, `focus/planner.blade.php`, dan `focus/insights.blade.php`.

```mermaid
flowchart TD
    A[User buka Pomodoro / Planner / Insights] --> B[Alpine init]
    B --> C{Komponen}
    C -- pomodoroTimer --> D[Restore localStorage pelajarin-pomodoro-state-v1]
    D --> E[Start/Pause/Reset/Skip mode]
    E --> F[Persist state ke localStorage]
    C -- focusPlanner --> G[Restore localStorage pelajarin-focus-planner-v1]
    G --> H[Tambah task, blok, template, reorder, complete]
    H --> I[Persist planner state]
    C -- focusInsights --> J[Baca storage Pomodoro dan Planner]
    J --> K[Hitung focus score, progress, recommendation]
```

## 5. Class Diagram Domain

Class diagram berikut fokus pada class Eloquent dan service utama yang ada di repository.

```mermaid
classDiagram
direction LR

class User {
  id
  name
  email
  role
  plan
  room_limit
  match_credits
  is_active
  provider
  provider_id
  provider_avatar
  isPremium() bool
}

class Material {
  user_id
  title
  original_filename
  file_path
  mime_type
  file_size
  raw_text
  status
  ocr_status
  ocr_engine
  ocr_warning
  ocr_completed_at
}

class AiSummary {
  material_id
  user_id
  title
  summary_text
  model
}

class ChatThread {
  user_id
  material_id
  title
  ai_status
  ai_error
}

class ChatMessage {
  thread_id
  role
  content
  token_count
}

class FlashcardDeck {
  material_id
  title
  description
  card_count
}

class Flashcard {
  flashcard_deck_id
  front
  back
  example
  difficulty
  sort_order
  review_count
  streak
  interval_minutes
  ease_factor
  last_reviewed_at
  next_review_at
}

class QuizSet {
  material_id
  title
  description
  question_count
}

class QuizQuestion {
  quiz_set_id
  prompt
  choices
  correct_choice
  explanation
  sort_order
}

class StudyProfile {
  user_id
  education_level
  primary_subject
  goal
  study_style
  bio
  availability
  is_matchmaking_enabled
}

class StudyRoom {
  owner_id
  name
  slug
  topic
  description
  visibility
  max_members
  is_active
}

class StudyRoomMember {
  study_room_id
  user_id
  role
  status
  joined_at
}

class StudyRoomMessage {
  study_room_id
  user_id
  reply_to_message_id
  content
  type
}

class MatchQueueEntry {
  user_id
  selected_topic
  preferred_level
  preferred_session_type
  status
  expires_at
  ROULETTE_TOPIC
}

class StudyMatch {
  user_one_id
  user_two_id
  topic
  status
  matched_at
  involves(User) bool
  partnerFor(User) User
}

class StudyMatchMessage {
  study_match_id
  user_id
  content
}

class UserBlock {
  user_id
  blocked_user_id
}

class UserReport {
  reporter_id
  reported_user_id
  reportable_type
  reportable_id
  reason
  status
}

class FeatureUsage {
  feature_name
  click_count
}

User "1" --> "*" Material : materials
User "1" --> "*" AiSummary : summaries
User "1" --> "*" ChatThread : chatThreads
User "1" --> "0..1" StudyProfile : studyProfile
User "1" --> "*" StudyRoom : ownedRooms
User "1" --> "*" StudyRoomMember : roomMemberships
User "1" --> "*" StudyRoomMessage : roomMessages
User "1" --> "*" MatchQueueEntry : matchQueueEntries
User "1" --> "*" StudyMatch : studyMatchesAsOne
User "1" --> "*" StudyMatch : studyMatchesAsTwo
User "1" --> "*" UserBlock : blockedUsers
User "1" --> "*" UserReport : reportsFiled

Material "1" --> "*" AiSummary : summaries
Material "1" --> "*" ChatThread : chatThreads
Material "1" --> "0..1" FlashcardDeck : flashcardDeck
Material "1" --> "0..1" QuizSet : quizSet

ChatThread "1" --> "*" ChatMessage : messages
FlashcardDeck "1" --> "*" Flashcard : cards
QuizSet "1" --> "*" QuizQuestion : questions

StudyRoom "1" --> "*" StudyRoomMember : members
StudyRoom "1" --> "*" StudyRoomMessage : messages

StudyMatch "1" --> "*" StudyMatchMessage : messages
StudyMatchMessage "*" --> "1" User : user
StudyRoomMessage "*" --> "1" User : user
StudyRoomMember "*" --> "1" User : user
```

## 6. Class Diagram Service, Controller, Event, dan Job

```mermaid
classDiagram
direction TB

class MaterialController {
  index()
  create()
  store(Request, MaterialTextExtractor, AiMaterialCleaner)
  show(Material)
}

class SummaryController {
  index()
  show(AiSummary)
}

class ChatThreadController {
  index()
  store(Request)
  show(ChatThread)
}

class ChatMessageController {
  index(Request, ChatThread)
  store(Request, ChatThread, AiUsageLimiter)
}

class FlashcardController {
  index(Request)
  generate(Request, StudyContentGenerator, AiContentGenerationLimiter)
  review(Request, FlashcardDeck, FlashcardReviewScheduler)
}

class QuizController {
  index(Request)
  generate(Request, StudyContentGenerator, AiContentGenerationLimiter)
  start(QuizSet)
  answer(Request, QuizSet)
  reset(QuizSet)
}

class StudyRoomController {
  index(Request)
  store(Request)
  show(Request, StudyRoom)
  join(Request, StudyRoom)
  leave(Request, StudyRoom)
}

class StudyRoomMessageController {
  index(Request, StudyRoom, TypingStateStore)
  typing(Request, StudyRoom, TypingStateStore)
  store(Request, StudyRoom)
}

class StudyMatchingController {
  index(Request, StudyMatchingService)
  roulette(Request, StudyMatchingService)
  updateProfile(Request)
  search(Request, StudyMatchingService)
  cancel(Request, StudyMatchingService)
  rouletteStart(Request, StudyMatchingService)
  rouletteNext(Request, StudyMatchingService)
  rouletteStop(Request, StudyMatchingService)
  show(StudyMatch)
  messages(Request, StudyMatch, TypingStateStore)
  typing(Request, StudyMatch, TypingStateStore)
  sendMessage(Request, StudyMatch)
  end(StudyMatch)
  block(Request, StudyMatch)
  report(Request, StudyMatch)
}

class AdminController {
  index()
  monitoringAi()
  statistikPembelajaran()
}

class AdminUserController {
  index()
  suspend(User)
  activate(User)
}

class AdminDocumentController {
  index()
  destroy(Material)
}

class MaterialTextExtractor {
  extractFromUpload(UploadedFile, maxOcrPages)
}

class AiMaterialCleaner {
  clean(title, text)
  summarize(title, text)
}

class StudyContentGenerator {
  generateFlashcards(Material, limit, avoidFronts)
  generateQuiz(Material, limit, avoidPrompts)
}

class FlashcardReviewScheduler {
  apply(Flashcard, rating)
}

class StudyMatchingService {
  enqueue(User, payload)
  enqueueRoulette(User)
  cancel(User)
  cancelRoulette(User)
  findMatchFor(User)
  findRouletteMatchFor(User)
}

class AiThreadResponder {
  <<interface>>
  generateReply(ChatThread) AiReplyResult
}

class OpenAiThreadResponder {
  generateReply(ChatThread)
}

class GenerateThreadAiReply {
  threadId
  handle(AiThreadResponder)
}

class AiUsageLimiter {
  check(User)
  hit(User)
}

class AiContentGenerationLimiter {
  check(User, feature)
  hit(User, feature)
}

class RealtimePayloads {
  threadMessage(ChatMessage)
  roomMessage(StudyRoomMessage)
  matchMessage(StudyMatchMessage)
  threadStatus(ChatThread)
}

class TypingStateStore {
  touch(scope, channelId, userId, userName)
  active(scope, channelId, excludeUserId)
}

MaterialController --> MaterialTextExtractor
MaterialController --> AiMaterialCleaner
MaterialController --> Material
MaterialController --> AiSummary

ChatMessageController --> AiUsageLimiter
ChatMessageController --> GenerateThreadAiReply
GenerateThreadAiReply --> AiThreadResponder
OpenAiThreadResponder ..|> AiThreadResponder
GenerateThreadAiReply --> RealtimePayloads

FlashcardController --> StudyContentGenerator
FlashcardController --> AiContentGenerationLimiter
FlashcardController --> FlashcardReviewScheduler
QuizController --> StudyContentGenerator
QuizController --> AiContentGenerationLimiter

StudyMatchingController --> StudyMatchingService
StudyMatchingController --> TypingStateStore
StudyRoomMessageController --> TypingStateStore
StudyRoomMessageController --> RealtimePayloads
StudyMatchingController --> RealtimePayloads
```

## 7. Realtime dan Broadcast Channel

Private channel didefinisikan di `routes/channels.php`.

| Channel | Akses | Dipakai Untuk |
| --- | --- | --- |
| `App.Models.User.{id}` | User hanya bisa akses channel miliknya | Notifikasi private user |
| `thread.{threadId}` | Owner `ChatThread` | Status AI dan pesan tutor AI |
| `room.{roomId}` | Public room boleh dibaca; private harus active member | Chat room dan typing room |
| `match.{matchId}` | User harus user_one/user_two pada `StudyMatch` | Chat match dan typing match |

Event broadcast:

| Event | Channel | Payload |
| --- | --- | --- |
| `ThreadMessageCreated` | `thread.{threadId}` | Message tutor/user dari `RealtimePayloads::threadMessage` |
| `ThreadAiStatusUpdated` | `thread.{threadId}` | Status `queued`, `processing`, `idle`, `failed` |
| `RoomMessageCreated` | `room.{roomId}` | Pesan room |
| `RoomTypingUpdated` | `room.{roomId}` | User typing di room |
| `StudyMatchMessageCreated` | `match.{matchId}` | Pesan antar partner |
| `StudyMatchTypingUpdated` | `match.{matchId}` | User typing di match |

## 8. Database dan Relasi Tabel

Skema berasal dari `database/migrations`.

| Tabel | Sumber Migration | Isi Utama |
| --- | --- | --- |
| `users` | `0001_01_01_000000_create_users_table.php`, add role/product/social fields | Akun, role, plan, limit, social provider |
| `materials` | `2026_04_17_000001_create_materials_table.php`, OCR fields | Materi upload, file metadata, raw text, OCR status |
| `ai_summaries` | `2026_04_17_000002_create_ai_summaries_table.php` | Ringkasan AI per material/user |
| `chat_threads` | `2026_04_17_000003_create_chat_threads_table.php`, AI status fields | Thread tutor AI |
| `chat_messages` | `2026_04_17_000004_create_chat_messages_table.php` | Pesan user/assistant pada thread |
| `feature_usages` | `2026_04_17_064708_create_feature_usages_table.php` | Counter klik fitur publik |
| `study_profiles` | `2026_04_20_090100_create_study_profiles_table.php` | Profil matching user |
| `study_rooms` | `2026_04_20_090200_create_study_rooms_tables.php` | Room belajar |
| `study_room_members` | `2026_04_20_090200_create_study_rooms_tables.php` | Keanggotaan room |
| `study_room_messages` | `2026_04_20_090200_create_study_rooms_tables.php` | Chat room |
| `match_queue_entries` | `2026_04_20_090300_create_study_matching_tables.php` | Antrean partner belajar |
| `study_matches` | `2026_04_20_090300_create_study_matching_tables.php` | Pasangan belajar aktif/selesai |
| `study_match_messages` | `2026_04_20_090300_create_study_matching_tables.php` | Chat partner belajar |
| `user_blocks` | `2026_04_20_090300_create_study_matching_tables.php` | User yang diblokir |
| `user_reports` | `2026_04_20_090300_create_study_matching_tables.php` | Laporan user/match |
| `flashcard_decks` | `2026_04_20_091000_create_flashcard_decks_table.php` | Deck flashcard per material |
| `flashcards` | `2026_04_20_091001_create_flashcards_table.php` | Card dan metadata review |
| `quiz_sets` | `2026_04_20_091002_create_quiz_sets_table.php` | Set kuis per material |
| `quiz_questions` | `2026_04_20_091003_create_quiz_questions_table.php` | Soal pilihan ganda |
| `notifications` | `2026_04_21_160000_create_notifications_table.php` | Database notifications Laravel |
| `jobs`, `cache` | Laravel default migrations | Queue dan cache |

## 9. Frontend Structure

| File/Folder | Fungsi |
| --- | --- |
| `resources/views/layouts/guest.blade.php` | Layout halaman guest/auth |
| `resources/views/layouts/user/app.blade.php` | Layout area user |
| `resources/views/layouts/user/sidebar.blade.php` | Navigasi user |
| `resources/views/layouts/admin/app.blade.php` | Layout admin |
| `resources/views/components/*` | Komponen Blade button, input, modal, dropdown, logo, loader |
| `resources/views/pages/public/welcome.blade.php` | Landing page |
| `resources/views/pages/public/pricing.blade.php` | Pricing |
| `resources/views/auth/*` | Login, register, reset, verify, confirm password |
| `resources/views/pages/user/materials/*` | Index, create, show material |
| `resources/views/pages/user/summaries/*` | List dan detail summary |
| `resources/views/pages/user/chat/*` | List dan detail tutor chat |
| `resources/views/pages/user/flashcards/index.blade.php` | UI flashcard |
| `resources/views/pages/user/quizzes/index.blade.php` | UI quiz |
| `resources/views/pages/user/rooms/*` | List dan detail study room |
| `resources/views/pages/user/matchmaking/*` | Matching, roulette, chat match |
| `resources/views/pages/user/focus/*` | Planner dan insights |
| `resources/views/pages/user/pomodoro.blade.php` | Timer Pomodoro |
| `resources/views/pages/admin/*` | Dashboard, monitoring, statistik, users, documents |
| `resources/js/app.js` | Entry Alpine, page loader, Pomodoro, Focus Planner, Focus Insights |
| `resources/js/realtime-chat.js` | Alpine realtime chat untuk thread/room/match |
| `resources/js/echo.js` | Laravel Echo/Reverb setup |
| `resources/js/bootstrap.js` | Axios/bootstrap frontend |
| `resources/css/app.css` | Tailwind CSS entry |

## 10. Route Mapping Ringkas

| Prefix/Route | Controller/View | Modul |
| --- | --- | --- |
| `/` | `pages.public.welcome` | Public |
| `/pricing` | `PricingController` | Public |
| `/track-feature` | `FeatureUsageController@track` | Analytics sederhana |
| `/dashboard` | Closure di `routes/web.php` | User dashboard |
| `/materials`, `/upload` | `MaterialController` | Material |
| `/summary`, `/summaries/{summary}` | `SummaryController` | Summary |
| `/chat`, `/chat/{chatThread}` | `ChatThreadController`, `ChatMessageController` | AI Chat |
| `/quiz` | `QuizController` | Quiz |
| `/flashcards` | `FlashcardController` | Flashcard |
| `/pomodoro`, `/focus-planner`, `/focus-insights` | Blade closure | Focus tools |
| `/rooms` | `StudyRoomController`, `StudyRoomMessageController` | Study room |
| `/matchmaking`, `/matches/{match}` | `StudyMatchingController` | Study matching |
| `/profile` | `ProfileController` | User profile |
| `/notifications` | `NotificationController` | Notifications |
| `/admin/*` | `AdminController`, `AdminUserController`, `AdminDocumentController` | Admin |
| `/login`, `/register`, `/forgot-password`, `/reset-password` | Auth controllers | Auth |
| `/auth/google/*`, `/auth/discord/*` | `SocialAuthController` | Social login |

## 11. Catatan Implementasi

1. Fitur AI chat berjalan asynchronous lewat `GenerateThreadAiReply`, sehingga queue worker perlu aktif agar status `queued/processing` berubah menjadi `idle` atau `failed`.
2. `StudyContentGenerator` mencoba AI lebih dulu, lalu fallback ke ekstraksi lokal berbasis teks jika AI gagal atau API key kosong.
3. Upload file mendukung plain text, HTML, DOCX, PPTX, XLSX, PDF, dan image OCR. Untuk scan PDF/image, sistem bergantung pada binary eksternal sesuai config OCR.
4. Pomodoro, planner, dan insights tidak memakai database; state disimpan di `localStorage`.
5. Realtime membutuhkan konfigurasi broadcasting/Reverb dan frontend Echo.
6. Authorization banyak dilakukan di controller dengan `abort_unless`, terutama untuk owner material/thread, membership room, dan participant match.
7. Admin area dilindungi middleware `auth` dan `AdminMiddleware`.

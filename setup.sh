#!/bin/bash

# ============================================================
# Structure des modules Nova Terra
# ============================================================

# ---------- Requests ----------
mkdir -p app/Modules/Requests/{Domain/{Entities,ValueObjects,Repositories},Application,Infrastructure,Http/Controllers}

touch app/Modules/Requests/Domain/Entities/Request.php
touch app/Modules/Requests/Domain/ValueObjects/RequestStatus.php
touch app/Modules/Requests/Domain/ValueObjects/RequestType.php
touch app/Modules/Requests/Domain/Repositories/RequestRepositoryInterface.php
touch app/Modules/Requests/Application/SubmitRequest.php
touch app/Modules/Requests/Application/TrackRequest.php
touch app/Modules/Requests/Application/ListCitizenRequests.php
touch app/Modules/Requests/Application/ListAgentRequests.php
touch app/Modules/Requests/Application/UpdateRequestStatus.php
touch app/Modules/Requests/Infrastructure/RequestModel.php
touch app/Modules/Requests/Infrastructure/RequestRepository.php
touch app/Modules/Requests/Http/Controllers/CitizenRequestController.php
touch app/Modules/Requests/Http/Controllers/AgentRequestController.php
touch app/Modules/Requests/Http/Routes.php

# ---------- Announcements ----------
mkdir -p app/Modules/Announcements/{Domain/{Entities,ValueObjects,Repositories},Application,Infrastructure,Http/Controllers}

touch app/Modules/Announcements/Domain/Entities/Announcement.php
touch app/Modules/Announcements/Domain/ValueObjects/AnnouncementType.php
touch app/Modules/Announcements/Domain/Repositories/AnnouncementRepositoryInterface.php
touch app/Modules/Announcements/Application/PublishAnnouncement.php
touch app/Modules/Announcements/Application/ListPublicAnnouncements.php
touch app/Modules/Announcements/Application/ListActiveAlerts.php
touch app/Modules/Announcements/Infrastructure/AnnouncementModel.php
touch app/Modules/Announcements/Infrastructure/AnnouncementRepository.php
touch app/Modules/Announcements/Http/Controllers/PublicAnnouncementController.php
touch app/Modules/Announcements/Http/Controllers/AgentAnnouncementController.php
touch app/Modules/Announcements/Http/Routes.php

# ---------- Contact ----------
mkdir -p app/Modules/Contact/{Domain/{Entities,Repositories},Application,Infrastructure,Http/Controllers}

touch app/Modules/Contact/Domain/Entities/ContactMessage.php
touch app/Modules/Contact/Domain/Repositories/ContactMessageRepositoryInterface.php
touch app/Modules/Contact/Application/SendContactMessage.php
touch app/Modules/Contact/Application/ListContactMessages.php
touch app/Modules/Contact/Infrastructure/ContactMessageModel.php
touch app/Modules/Contact/Infrastructure/ContactMessageRepository.php
touch app/Modules/Contact/Http/Controllers/CitizenContactController.php
touch app/Modules/Contact/Http/Controllers/AgentContactController.php
touch app/Modules/Contact/Http/Routes.php

# ---------- Catalog ----------
mkdir -p app/Modules/Catalog/{Application,Infrastructure,Http/Controllers}

touch app/Modules/Catalog/Application/ListServices.php
touch app/Modules/Catalog/Application/ListFeaturedServices.php
touch app/Modules/Catalog/Infrastructure/ServiceModel.php
touch app/Modules/Catalog/Http/Controllers/PublicServiceController.php
touch app/Modules/Catalog/Http/Routes.php

# ---------- Shared ----------
mkdir -p app/Shared/{Services,Helpers}

touch app/Shared/Services/AiService.php

# ---------- Views ----------
mkdir -p app/Views/layouts
mkdir -p app/Views/partials
mkdir -p app/Views/public/{services,announcements}
mkdir -p app/Views/citizen/{requests,contact,profile}
mkdir -p app/Views/agent/{requests,announcements,contact}

touch app/Views/layouts/base.php
touch app/Views/partials/navbar.php
touch app/Views/partials/flash.php
touch app/Views/partials/breadcrumb.php

touch app/Views/public/home.php
touch app/Views/public/services/index.php
touch app/Views/public/services/show.php
touch app/Views/public/announcements/index.php
touch app/Views/public/announcements/show.php

touch app/Views/citizen/requests/index.php
touch app/Views/citizen/requests/new.php
touch app/Views/citizen/requests/show.php
touch app/Views/citizen/contact/new.php
touch app/Views/citizen/profile.php

touch app/Views/agent/dashboard.php
touch app/Views/agent/requests/index.php
touch app/Views/agent/announcements/new.php
touch app/Views/agent/contact/index.php

# ============================================================
echo "✅ Structure Nova Terra créée."
find app/Modules app/Shared app/Views -type f | sort
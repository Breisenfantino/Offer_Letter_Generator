<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="offer.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hello, <span>H R</span></h3>
      <h1>Welcome <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>
<div id="app"></div>

<script>
  const templates = [
    {
      id: 1,
      name: '<h2>Template 1</h2>',
      content: `
        <p>[Date]</p>
        <p>[Candidate’s Full Name]<br>
        [Candidate’s Address]<br>
        [City, State, ZIP Code]</p>
        <p>Dear [Candidate’s First Name],</p>
        <p>We are pleased to extend an offer of employment to you for the position of <strong>[Job Title]</strong> at <strong>[Your Company Name]</strong>. We believe your skills and experience are an excellent match for our team and look forward to working with you.</p>
        <p><strong>Position:</strong><br>
        <strong>Job Title:</strong> [Job Title]<br>
        <strong>Department:</strong> [Department Name]<br>
        <strong>Reporting to:</strong> [Manager’s Name and Title]</p>
        <p><strong>Start Date:</strong><br>
        Your expected start date will be <strong>[Start Date]</strong>.</p>
        <p><strong>Salary and Benefits:</strong><br>
        <ul>
          <li><strong>Base Salary:</strong> Your starting salary will be <strong>[Salary Amount]</strong> per [year/month/hour], payable in accordance with the company’s standard payroll schedule.</li>
          <li><strong>Bonus/Incentives:</strong> [Details if applicable]</li>
          <li><strong>Benefits:</strong> You will be eligible for a range of benefits, including [health insurance, retirement plans, paid time off, etc.], in accordance with the company’s policies.</li>
          <li><strong>Other Compensation:</strong> [Details if applicable]</li>
        </ul></p>
        <p><strong>Employment Status:</strong><br>
        This position is [full-time/part-time/contract] and is [exempt/non-exempt] under the Fair Labor Standards Act.</p>
        <p><strong>Conditions of Employment:</strong><br>
        This offer is contingent upon:
        <ul>
          <li>Satisfactory completion of a background check.</li>
          <li>Verification of your ability to legally work in the [Country].</li>
          <li>Signing of [any required agreements, such as non-compete or confidentiality agreements].</li>
        </ul></p>
        <p><strong>At-Will Employment:</strong><br>
        Please note that your employment with <strong>[Your Company Name]</strong> is at-will, meaning either you or the company may terminate the employment relationship at any time, with or without cause or notice.</p>
        <p><strong>Acceptance of Offer:</strong><br>
        Please confirm your acceptance of this offer by signing and returning this letter by <strong>[Acceptance Deadline Date]</strong>.</p>
        <p>We are excited about the prospect of you joining our team and contributing to <strong>[Your Company Name]</strong>'s success. If you have any questions or need further information, please feel free to contact me at <strong>[Your Phone Number]</strong> or <strong>[Your Email Address]</strong>.</p>
        <p>Sincerely,</p>
        <p>[Your Full Name]<br>[Your Job Title]<br>[Your Company Name]</p>
      `
    },
    {
      id: 2,
      name: '<h2>Template 2</h2>',
      content: `
        <p>[Date]</p>
        <p>Dear [Candidate’s First Name],</p>
        <p>We are thrilled to offer you the position of <strong>[Job Title]</strong> at <strong>[Your Company Name]</strong>. Your background and skills are a perfect match for our team.</p>
        <p><strong>Position Details:</strong><br>
        <strong>Job Title:</strong> [Job Title]<br>
        <strong>Department:</strong> [Department Name]<br>
        <strong>Start Date:</strong> [Start Date]</p>
        <p><strong>Compensation and Benefits:</strong><br>
        <ul>
          <li><strong>Salary:</strong> [Salary Amount]</li>
          <li><strong>Bonus/Incentives:</strong> [Details if applicable]</li>
          <li><strong>Benefits:</strong> [Details]</li>
        </ul></p>
        <p>We look forward to welcoming you to our team. Please sign below to accept this offer.</p>
        <p>Sincerely,</p>
        <p>[Your Full Name]<br>[Your Job Title]<br>[Your Company Name]</p>
      `
    },
    {
      id: 3,
      name: '<h2>Template 3</h2>',
      content: `
        <p>[Date]</p>
        <p>[Candidate’s Full Name]<br>
        [Candidate’s Address]</p>
        <p>Dear [Candidate’s First Name],</p>
        <p>We are delighted to offer you the role of <strong>[Job Title]</strong> at <strong>[Your Company Name]</strong>. Below are the terms and conditions of your employment:</p>
        <p><strong>Job Title:</strong> [Job Title]<br>
        <strong>Start Date:</strong> [Start Date]<br>
        <strong>Salary:</strong> [Salary Amount] per [year/month/hour]</p>
        <p>Please confirm your acceptance by signing this letter and returning it by [Acceptance Deadline Date].</p>
        <p>Best regards,</p>
        <p>[Your Full Name]<br>[Your Job Title]<br>[Your Company Name]</p>
      `
    }
  ];

  const extractPlaceholders = (templateContent) => {
    const regex = /\[([^\]]+)\]/g;
    const matches = [];
    let match;
    while ((match = regex.exec(templateContent)) !== null) {
      matches.push(match[1]);
    }
    return Array.from(new Set(matches));
  };

  let selectedTemplate = null;
  let formData = {};
  let previewContent = '';

  const renderTemplateSelection = () => {
    const app = document.getElementById('app');
    app.innerHTML = '<h1>Select a Template</h1>';
    templates.forEach(template => {
      const button = document.createElement('button');
      button.innerHTML = template.name;
      button.onclick = () => {
        selectedTemplate = template;
        renderTemplateDetails();
      };
      app.appendChild(button);
    });
  };

  const renderTemplateDetails = () => {
    const app = document.getElementById('app');
    app.innerHTML = `<h1>Fill in the Details:</h1>`;
    const placeholders = extractPlaceholders(selectedTemplate.content);
    placeholders.forEach(placeholder => {
      const formGroup = document.createElement('div');
      formGroup.className = 'form-group';
      const label = document.createElement('label');
      label.innerText = placeholder;
      const input = document.createElement('input');
      input.name = placeholder;
      input.oninput = (e) => {
        formData[placeholder] = e.target.value;
      };
      formGroup.appendChild(label);
      formGroup.appendChild(input);
      app.appendChild(formGroup);
    });
    const backButton = document.createElement('button');
    backButton.className = 'back';
    backButton.innerHTML = '<h2>Back</h2>';
    backButton.onclick = renderTemplateSelection;
    backButton.style.marginLeft = '32%';
    app.appendChild(backButton);

    const previewButton = document.createElement('button');
    previewButton.className = 'preview';
    previewButton.innerHTML = '<h2>Preview</h2>';
    previewButton.onclick = renderTemplatePreview;
    app.appendChild(previewButton);
  };

  const renderTemplatePreview = () => {
    const app = document.getElementById('app');
    previewContent = selectedTemplate.content;
    Object.keys(formData).forEach(key => {
      const regex = new RegExp(`\\[${key}\\]`, 'g');
      previewContent = previewContent.replace(regex, formData[key]);
    });
    app.innerHTML = `<h2>&nbsp;&nbsp;&nbsp;&nbsp;Preview</h2>`;
    const previewDiv = document.createElement('div');
    previewDiv.className = 'template-preview';
    previewDiv.innerHTML = previewContent;
    previewDiv.style.marginLeft = '8%';
    app.appendChild(previewDiv);

    const backButton = document.createElement('button');
    backButton.className = 'back';
    backButton.innerHTML = '<h2>Back</h2>';
    backButton.onclick = renderTemplateDetails;
    backButton.style.marginLeft = '32%';
    app.appendChild(backButton);

    const downloadButton = document.createElement('button');
    downloadButton.className = 'download';
    downloadButton.innerHTML = '<h2>Download</h2>';
    downloadButton.onclick = downloadPreview;
    app.appendChild(downloadButton);
  };

  const downloadPreview = () => {
    const blob = new Blob([previewContent], { type: 'text/html' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'preview.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  };

  document.addEventListener('DOMContentLoaded', renderTemplateSelection);
</script>

</body>
</html>